<?php

namespace App\Controllers;


use CodeIgniter\Shield\Models\UserIdentityModel;
use Config\Services;





class DashboardController extends BaseController
{
    public function index()
    {
        $user = Services::auth()->user('username');
        $data["user"] = $user;

        return view('layouts/MainLayout', [
            'sidebar' => view('components/sidebars/sidebar'),
            'content' => view('pages/dashboard', $data),
        ]);
    }


    public function profile()
    {
        $currentUser = Services::auth()->user();
        $userData = [
            'user' => $currentUser,
            'image' => $this->encodeImage($currentUser->imagePath),
        ];
        $user = Services::auth()->user();
        $data["user"] = $user;
        $image = $user->imagePath;

        $mimeType = 'image/jpeg';
        if (strpos($image, '.png') !== false) {
            $mimeType = 'image/png';
        } elseif (strpos($image, '.gif') !== false) {
            $mimeType = 'image/gif';
        }


        $data["image"] = 'data:' . $mimeType . ';base64,' . base64_encode($image);


        return view('layouts/MainLayout', [
            'sidebar' => view('components/sidebars/sidebar'),
            'content' => view('pages/profile', $userData),
            'content' => view('pages/profile', $data),
        ]);
    }

    private function encodeImage(string $imageData): string
    {
        $mimeType = $this->detectMimeType($imageData);
        return 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
    }

    private function detectMimeType(string $imageData): string
    {
        if (strpos($imageData, '.png') !== false) {
            return 'image/png';
        }
        if (strpos($imageData, '.gif') !== false) {
            return 'image/gif';
        }
        return 'image/jpeg';

    }

    public function updateProfile()
    {
        // dd($this->request->getVar('image'));
        $userId = $this->request->getGet('id');
        $userModel = auth()->getProvider();
        $identityModel = new UserIdentityModel();

        $passwords = service('passwords');


        if ($this->request->getFile('image') != '') {
            $validation = $this->validate([
                'image' => [
                    'uploaded[image]',
                    'mime_in[image,image/jpg,image/jpeg,image/png]',
                    'max_size[image,2048]', // 2MB max
                ],
            ]);

            if (!$validation) {
                return redirect()->back()->withInput()->with('message', 'Upload failed')->with('validation', \Config\Services::validation());
            }

            $imageFile = $this->request->getFile('image');
            if ($imageFile->isValid() && !$imageFile->hasMoved()) {

                $newName = $imageFile->getRandomName();
                $imageBlob = file_get_contents($imageFile->getTempName());

                $imageFile->move(WRITEPATH . 'uploads', $newName);

                if (
                    $userModel->update($userId, [

                        'imagePath' => $imageBlob,
                    ])
                ) {
                    return redirect()->back()->with('message', 'Image uploaded successfully');
                } else {
                    return redirect()->back()->with('message', 'Failed to save image data');
                }
            }
        }


        $userModel->update($userId, [
            'username' => $this->request->getVar('username'),

        ]);

        if (!empty($this->request->getVar('email')) || !empty($this->request->getVar('password'))) {
            $identityModel->update($userId, [
                'secret' => $this->request->getVar('email'),
                'secret2' => $passwords->hash($this->request->getVar('password')),

            ]);
        }

        return redirect()->back();
    }

    public function search()
    {
        $apiKey = '45099767-669609db62b04ded3d7e39545';
        $keyword = $this->request->getVar('q') ?? '';
        $client = Services::curlrequest();
        $photoURL = 'https://pixabay.com/api/?key=' . $apiKey . '&q=' . urlencode($keyword) . '&image_type=photo';
        $videoURL = 'https://pixabay.com/api/videos/?key=' . $apiKey . '&q=' . urlencode($keyword);

        try {
            $photoResponse = $client->get($photoURL);
            $videoResponse = $client->get($videoURL);

            $photoData = json_decode($photoResponse->getBody(), true);
            $videoData = json_decode($videoResponse->getBody(), true);


            $photos = isset($photoData['hits']) && is_array($photoData['hits']) ? $photoData['hits'] : [];
            $videos = isset($videoData['hits']) && is_array($videoData['hits']) ? $videoData['hits'] : [];

            $data['hits'] = array_merge($photos, $videos);


        } catch (\Exception $e) {
            log_message('error', $e->getMessage());

        }



        return view('layouts/MainLayout', [
            'sidebar' => view('components/sidebars/sidebar'),
            'content' => view('pages/search', $data),
        ]);
    }



}
