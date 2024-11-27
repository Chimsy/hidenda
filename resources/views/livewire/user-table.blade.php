<div class="p-6 bg-gray-100 dark:bg-gray-800">

    <!-- Add Record Button -->
    <button wire:click="resetFields" class="mt-4 bg-green-500 text-white px-8 py-2  rounded">Add Record</button>

    <!-- Summary Table -->
    <div class="overflow-x-auto shadow-lg rounded-lg">
        <table class="min-w-full bg-white dark:bg-gray-900 rounded-lg">
            <thead class="bg-gray-200 dark:bg-gray-700">
            <tr>
                <th class="py-2 px-4 text-left">Name</th>
                <th class="py-2 px-4 text-left">Email</th>
                <th class="py-2 px-4 text-left">Phone</th>
                <th class="py-2 px-4 text-left">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr class="border-b dark:border-gray-600">
                    <td class="py-2 px-4">{{ $user->name }}</td>
                    <td class="py-2 px-4">{{ $user->email }}</td>
                    <td class="py-2 px-4">{{ $user->phone }}</td>
                    <td class="py-2 px-4">
                        <button wire:click="selectUser({{ $user->id }})" class="bg-blue-500 text-white px-3 py-1 rounded">View</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>



    <!-- Modal -->
    @if($selectedUser || $isEdit)
        <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="bg-white dark:bg-gray-900 p-6 rounded-lg">
                <input type="text" wire:model="name" placeholder="Name" class="block w-full mt-2 p-2 border rounded dark:bg-gray-700">
                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror

                <input type="email" wire:model="email" placeholder="Email" class="block w-full mt-2 p-2 border rounded dark:bg-gray-700">
                @error('email') <span class="text-red-500">{{ $message }}</span> @enderror

                <input type="text" wire:model="phone" placeholder="Phone" class="block w-full mt-2 p-2 border rounded dark:bg-gray-700">
                @error('phone') <span class="text-red-500">{{ $message }}</span> @enderror

                <div class="flex justify-end mt-4 space-x-4">
                    <button wire:click="update" @if(!$isEdit) disabled @endif class="bg-blue-500 text-white px-4 py-2 rounded @if(!$isEdit) opacity-50 cursor-not-allowed @endif">Edit</button>
                    <button wire:click="delete({{ $selectedUser->id ?? '' }})" @if(!$isEdit) disabled @endif class="bg-red-500 text-white px-4 py-2 rounded @if(!$isEdit) opacity-50 cursor-not-allowed @endif">Delete</button>
                </div>
            </div>
        </div>
    @endif
</div>
