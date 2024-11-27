<div>
    <!-- Summary Table -->
    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>phone</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr wire:click="selectUser({{ $user->id }})">
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>
                    <button wire:click="selectUser({{ $user->id }})">View</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Add Record Button -->
    <button wire:click="resetFields">Add Record</button>

    <!-- Modal -->
    @if($selectedUser || $isEdit)
        <div>
            <input type="text" wire:model="name" placeholder="Name">
            @error('name') <span>{{ $message }}</span> @enderror

            <input type="email" wire:model="email" placeholder="Email">
            @error('email') <span>{{ $message }}</span> @enderror

            <input type="text" wire:model="phone" placeholder="phone">
            @error('phone') <span>{{ $message }}</span> @enderror

            <input type="password" wire:model="password" placeholder="Password">
            @error('password') <span>{{ $message }}</span> @enderror

            <button wire:click="create" @if($isEdit) disabled @endif>Create</button>
            <button wire:click="update" @if(!$isEdit) disabled @endif>Edit</button>
            <button wire:click="delete({{ $selectedUser->id ?? '' }})" @if(!$isEdit) disabled @endif>Delete</button>
        </div>
    @endif
</div>
