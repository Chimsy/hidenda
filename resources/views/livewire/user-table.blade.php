<div>
    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr wire:click="openModal({{ $user->id }})" style="cursor: pointer;">
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>
                    <button wire:click="deleteUser({{ $user->id }})" class="btn btn-danger btn-sm">Delete</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <!-- Add Record Button -->
    <button wire:click="openModal()" class="btn btn-primary">Add Record</button>

    <!-- Modal for Add/Edit User -->
    <div
        id="userModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="userModalLabel"
        aria-hidden="true"
        class="modal fade">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">{{ $isEditMode ? 'Edit User' : 'Add User' }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="saveUser">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" wire:model="name" class="form-control" id="name" required>
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" wire:model="email" class="form-control" id="email" required>
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" wire:model="phone" class="form-control" id="phone" required>
                            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" wire:model="password" class="form-control"
                                   id="password" {{ !$isEditMode ? 'required' : '' }}>
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                                wire:click="closeModal">
                                Close
                            </button>
                            <button
                                type="submit"
                                class="btn btn-primary" {{ $isEditMode && !$this->hasChanges() ? 'disabled' : '' }}>
                                {{ $isEditMode ? 'Save Changes' : 'Add User' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('open-modal', event => {
        $('#userModal').modal('show');
    });

    window.addEventListener('close-modal', event => {
        $('#userModal').modal('hide');
    });
</script>
