<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
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
    public $showAddModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'phone' => 'required|digits:11|starts_with:07',
        'password' => 'required|string|min:8'
    ];

    public function render(): View
    {
        $this->users = User::all();
        return view('livewire.user-table');
    }

    public function showAddModal(): void
    {
        $this->resetFields();
        $this->showAddModal = true;
    }

    public function hideAddModal(): void
    {
        $this->showAddModal = false;
    }

    public function resetFields(): void
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->password = '';
        $this->isEdit = false;
    }

    public function showEditModal(): void
    {
        $this->isEdit = true;
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
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->selectedUser->id),
            ],
            'phone' => 'required|digits:11|starts_with:07',
        ]);

        $this->selectedUser->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => bcrypt($this->password),
        ]);

        $this->resetFields();
        $this->hideEditModal();
    }

    public function hideEditModal(): void
    {
        $this->isEdit = false;
        $this->selectedUser = null;
    }

    public function delete(User $user): void
    {
        $user->delete();
        $this->resetFields();
        $this->hideEditModal();
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
        $this->hideAddModal();
    }
}
