<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * @method dispatchBrowserEvent(string $string)
 */
class UserTable extends Component
{
    use WithPagination;

    public $selectedUser = null;
    public $name, $email, $password, $phone;
    public $isEditMode = false;
    public $newUser = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'phone' => 'required|regex:/^07\d{9}$/',  // 11-digit phone starting with 07
    ];

    protected $validationAttributes = [
        'phone' => 'telephone number',
    ];

    public function render()
    {
        $users = User::paginate(10);
        return view('livewire.user-table', compact('users'));
    }

    public function openModal($userId = null): void
    {
        if ($userId) {
            $this->selectedUser = User::find($userId);
            $this->name = $this->selectedUser->name;
            $this->email = $this->selectedUser->email;
            $this->phone = $this->selectedUser->phone;
            $this->isEditMode = true;
        } else {
            $this->newUser = true;
            $this->name = '';
            $this->email = '';
            $this->phone = '';
            $this->password = '';
            $this->isEditMode = false;
        }

        $this->dispatchBrowserEvent('open-modal');
    }

    public function closeModal(): void
    {
        $this->dispatchBrowserEvent('close-modal');
        $this->resetFields();
    }

    private function resetFields(): void
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->password = '';
        $this->selectedUser = null;
        $this->isEditMode = false;
        $this->newUser = false;
    }

    public function saveUser(): void
    {
        $this->validate();

        if ($this->newUser) {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'phone' => $this->phone,
            ]);
        } else {
            $this->selectedUser->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'password' => $this->password ? Hash::make($this->password) : $this->selectedUser->password,
            ]);
        }

        session()->flash('message', 'User saved successfully.');
        $this->closeModal();
    }

    public function deleteUser($userId): void
    {
        $user = User::find($userId);
        $user->delete();
        session()->flash('message', 'User deleted successfully.');
    }
}
