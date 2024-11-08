@extends('layouts.master')
@section('title')
    Room Management
@endsection
@section('page-title')
    Room Management
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="mb-3">
                    <h5 class="card-title">Room List</h5>
                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-3">
                    <div>
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link active" href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Grid"><i class="bx bx-grid-alt"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <a href="#" data-bs-toggle="modal" data-bs-target="#addRoomModal" class="btn btn-primary">
                            <i class="bx bx-plus me-1"></i> Add New Room
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2" id="roomsContainer">
            @foreach ($rooms as $room)
            {{-- {{ $room->roomUrl[0]}} --}}
                <div class="col-xl-3 col-sm-6 room-card" data-room-id="{{ $room->id }}">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-muted mt-3 mb-0">{{ $room->name }}</h5>

                            <div class="mt-3 pt-1">
                                <p class="mb-0">
                                    <i class="mdi mdi-phone font-size-15 align-middle pe-2 text-primary"></i>
                                    Total Visitors: {{ $room->total_visitors ?? 0 }}
                                </p>
                                <p class="mb-0 mt-2">
                                    <i class="mdi mdi-email font-size-15 align-middle pe-2 text-primary"></i>
                                    Total Messages: {{ $room->total_messages ?? 0 }}
                                </p>
                                <p class="mb-0 mt-2">
                                    <i class="mdi mdi-google-maps font-size-15 align-middle pe-2 text-primary"></i>
                                    Status: <span
                                        class="badge
                                @if ($room->status == 'active') bg-success
                                @elseif($room->status == 'pending') bg-warning
                                @else bg-danger @endif">
                                        {{ ucfirst($room->status) }}
                                    </span>
                                </p>
                                <p class="mb-0 mt-2">
                                    <i class="mdi mdi-email font-size-15 align-middle pe-2 text-primary"></i>
                                    <span
                                        class="badge
                                @if (!empty($room->roomUrl[0]->url)) bg-success
                                @else bg-danger @endif">
                                @if (!empty($room->roomUrl[0]->url)) {{ $room->roomUrl[0]->url }}@else No URL available @endif
                                    </span>
                                </p>

                            </div>

                            <div class="d-flex gap-2 pt-4">
                                <button type="button" onclick="openEditModal({{ $room->id }})"
                                    class="btn btn-soft-primary btn-sm w-50">
                                    <i class="bx bx-edit me-1"></i> Edit
                                </button>

                                <button type="button" onclick="deleteRoom({{ $room->id }})"
                                    class="btn btn-danger btn-sm w-50">
                                    <i class="bx bx-trash me-1"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Add New Room Modal -->
    <div class="modal fade" id="addRoomModal" tabindex="-1" aria-labelledby="addRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRoomModalLabel">Add New Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="addRoom-name">Room Name</label>
                                <input type="text" class="form-control" placeholder="Enter Room Name" id="addRoom-name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="addRoom-status">
                                    <option value="active">Active</option>
                                    <option value="pending">Pending</option>
                                    <option value="deactive">Deactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12 text-end">
                            <button type="button" class="btn btn-danger me-1" data-bs-dismiss="modal">
                                <i class="bx bx-x me-1 align-middle"></i> Cancel
                            </button>
                            <button type="button" class="btn btn-success" id="btn-save-room">
                                <i class="bx bx-check me-1 align-middle"></i> Confirm
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Room Modal -->
    <div class="modal fade" id="editRoomModal" tabindex="-1" aria-labelledby="editRoomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoomModalLabel">Edit Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label" for="editRoom-name">Room Name</label>
                                <input type="text" class="form-control" placeholder="Enter Room Name"
                                    id="editRoom-name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="editRoom-status">
                                    <option value="active">Active</option>
                                    <option value="pending">Pending</option>
                                    <option value="deactive">Deactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12 text-end">
                            <button type="button" class="btn btn-danger me-1" data-bs-dismiss="modal">
                                <i class="bx bx-x me-1 align-middle"></i> Cancel
                            </button>
                            <button type="button" class="btn btn-primary" id="btn-update-room">
                                <i class="bx bx-check me-1 align-middle"></i> Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals for Success and Error Feedback -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <i class="bx bx-check-circle display-1 text-success"></i>
                    <h4 class="mt-3" id="successModalTitle">Operation Successful</h4>
                    <button type="button" class="btn btn-secondary mt-3" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <i class="bx bx-x-circle display-1 text-danger"></i>
                    <h4 class="mt-3">Operation Failed</h4>
                    <p class="mt-2" id="errorModalMessage">An error occurred. Please try again.</p>
                    <button type="button" class="btn btn-secondary mt-3" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Save Room Event Listener
            document.getElementById('btn-save-room').addEventListener('click', function() {
                const name = document.getElementById('addRoom-name').value;
                const status = document.getElementById('addRoom-status').value;

                if (!name.trim()) {
                    showErrorModal('Room name cannot be empty.');
                    return;
                }

                fetch("{{ route('room.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            name,
                            status
                        })
                    })
                    .then(handleResponse)
                    .then(data => {
                        if (data.status === 'Success') {
                            closeModal('addRoomModal');
                            showSuccessModal('Room added successfully');
                            reloadRooms();
                        } else {
                            showErrorModal(data.error || 'Failed to save room');
                        }
                    })
                    .catch(handleError);
            });

            // Edit Room Event Listener
            document.getElementById('btn-update-room').addEventListener('click', function() {
                const roomId = this.getAttribute('data-room-id');
                const name = document.getElementById('editRoom-name').value;
                const status = document.getElementById('editRoom-status').value;

                if (!name.trim()) {
                    showErrorModal('Room name cannot be empty.');
                    return;
                }

                const url = @json(route('room.update', ['id' => 'ROOM_ID'])).replace('ROOM_ID', roomId);

                fetch(url, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            name,
                            status
                        })
                    })
                    .then(handleResponse)
                    .then(data => {
                        if (data.status === 'Success') {
                            closeModal('editRoomModal');
                            showSuccessModal('Room updated successfully');
                            reloadRooms();
                        } else {
                            showErrorModal(data.error || 'Failed to update room');
                        }
                    })
                    .catch(handleError);
            });
        });

        // Function to open Edit Modal
        function openEditModal(roomId) {
            const roomShowUrl = @json(route('room.show', ['id' => 'ROOM_ID']));
            const url = roomShowUrl.replace('ROOM_ID', roomId);

            fetch(url)
                .then(handleResponse)
                .then(data => {
                    if (data.status === 'Success') {
                        const room = data.data;
                        document.getElementById('editRoom-name').value = room.name;
                        document.getElementById('editRoom-status').value = room.status;

                        // Store the room ID for updating
                        document.getElementById('btn-update-room').setAttribute('data-room-id', roomId);

                        // Show the edit modal
                        const editModal = new bootstrap.Modal(document.getElementById('editRoomModal'));
                        editModal.show();
                    } else {
                        showErrorModal('Failed to load room data');
                    }
                })
                .catch(handleError);
        }

        // Function to Delete Room
        function deleteRoom(roomId) {
            if (!confirm('Are you sure you want to delete this room?')) return;

            const roomDeleteUrl = @json(route('room.destroy', ['id' => 'ROOM_ID']));
            const url = roomDeleteUrl.replace('ROOM_ID', roomId);

            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(handleResponse)
                .then(data => {
                    if (data.status === 'Success') {
                        showSuccessModal('Room deleted successfully');
                        removeRoomFromList(roomId);
                    } else {
                        showErrorModal(data.error || 'Failed to delete room');
                    }
                })
                .catch(handleError);
        }

        // Utility Functions
        function handleResponse(response) {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        }

        function handleError(error) {
            console.error('Error:', error);
            showErrorModal('An unexpected error occurred.');
        }

        function showSuccessModal(message) {
            document.getElementById('successModalTitle').textContent = message;
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        }

        function showErrorModal(message) {
            document.getElementById('errorModalMessage').textContent = message;
            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
        }

        function closeModal(modalId) {
            const modal = bootstrap.Modal.getInstance(document.getElementById(modalId));
            if (modal) modal.hide();
        }

        function removeRoomFromList(roomId) {
            const roomCard = document.querySelector(`.room-card[data-room-id="${roomId}"]`);
            if (roomCard) {
                roomCard.remove();
            }
        }

        function reloadRooms() {
            location.reload();
        }
    </script>
@endsection



@section('scripts')
    <!-- App js -->
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
