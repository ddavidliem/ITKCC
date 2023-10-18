@extends('layouts.user')

@section('content')
    <div class="container p-4">
        <div class="d-flex justify-content-evenly">
            <div class="col-lg-3 px-2">
                <div class="bg-white rounded border-1 min-vh-25 p-3 list-group list-group-flush">
                    <button type="button"
                        class="list-group-item list-group-item-action fw-semibold d-flex justify-content-between"
                        data-bs-toggle="modal" data-bs-target="#profileImgModal">
                        Update Foto Profile
                        @if (!$user->profile)
                            <span class="badge text-bg-secondary" id="profileBadge" data-toggle="popover"
                                data-content="Please Upload Profile Picture">!</span>
                        @endif
                    </button>
                    <button type="button" class="list-group-item list-group-item-action fs-6 fw-semibold"
                        data-bs-toggle="modal" data-bs-target="#editModal">Edit Profile</button>
                    <button type="button" class="list-group-item list-group-item-action fs-6 fw-semibold"
                        data-bs-toggle="modal" data-bs-target="#sertifikatModal">
                        Sertifikat
                    </button>
                    <button type="button" class="list-group-item list-group-item-action fs-6 fw-semibold"
                        data-bs-toggle="modal" data-bs-target="#pengalamanModal">Pengalaman</button>
                    <a href="/Home/User/Resume" class="list-group-item list-group-item-action fs-6 fw-semibold">Resume
                        @if (!$user->resume)
                            <span class="badge text-bg-secondary" id="profileBadge" data-toggle="popover"
                                data-content="Please Upload Profile Picture">!</span>
                        @endif
                    </a>
                </div>
            </div>
            <div class="col-lg-9">
                @include('user.modal.profile-image')
                @include('user.modal.edit')
                @include('user.modal.sertifikat')
                @include('user.modal.pengalaman')
                <div id="profile">
                    @include('user.profile.profile')
                </div>
            </div>
        </div>

    </div>
    </div>
@endsection

@push('script')
    <script type="module">
        document.addEventListener('DOMContentLoaded', function() {
            const pengalamanModal = document.getElementById('pengalamanModal');
            pengalamanModal.addEventListener('change', function(event) {
                const clickedCheckbox = event.target;
                if (clickedCheckbox.classList.contains('modal-checkbox')) {
                    const modal = clickedCheckbox.closest('.modal');
                    const selectInput = modal.querySelectorAll('.end-date');

                    if (clickedCheckbox.checked) {
                        Array.from(selectInput).forEach(selectInput => {
                            selectInput.disabled = true;
                            selectInput.value = selectInput.querySelector('option:first-child')
                                .value;
                        })
                    } else {
                        Array.from(selectInput).forEach(selectInput => {
                            selectInput.disabled = false;
                        })
                    }
                }

            })
        });


        (() => {
            'use strict';
            const modals = document.querySelectorAll('.modal');
            Array.from(modals).forEach(modal => {
                const forms = modal.querySelectorAll('.form-validate');
                Array.from(forms).forEach(form => {
                    form.addEventListener('submit', event => {
                        if (form.closest('.modal') === modal && !form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            });
        })();
    </script>
@endpush
