<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UserTable extends Component
{
    public $users;
    public $selectedUser;
    public $name;
    public $email;
    public $phone;
    public $password;
    public $isEdit = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|digits:11|starts_with:07',
        'password' => 'required|string|min:8'
    ];

    public function render()
    {
        $this->users = User::all();
        return view('livewire.user-table');
    }

    public function selectUser(User $user): void
    {
        $this->selectedUser = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->isEdit = true;
    }

    public function update(): void
    {
        $this->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->selectedUser->id),
            ],
        ]);

        $this->selectedUser->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => bcrypt($this->password),
        ]);

        $this->resetFields();
    }

    public function resetFields(): void
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->password = '';
        $this->isEdit = false;
    }

    public function delete(User $user): void
    {
        $user->delete();
        $this->resetFields();
    }

    public function create(): void
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => bcrypt($this->password),
        ]);

        $this->resetFields();
    }
}
