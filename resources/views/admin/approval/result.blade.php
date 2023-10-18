@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="min-vh-15 bg-white rounded p-4 d-flex">
            <div class="col-3 d-flex align-items-center">
                <h3 class="fw-semibold col-4 ">Approval</h3>
            </div>
            <div class="col-6 d-flex">
                <div class="mx-4">
                    <h6 class="fw-semibold">Total Approval</h6>
                </div>
                <div class="mx-4">
                    <h6 class="fw-semibold">Status Approved</h6>
                </div>
                <div class="mx-4">
                    <h6 class="fw-semibold">Status Pending</h6>
                </div>
                <div class="mx-4">
                    <h6 class="fw-semibold">Status Not Approved</h6>
                </div>
            </div>
            <div class="col-3 p-1">
                <form action="">
                    @csrf
                    <div class="my-2">
                        <input type="text" role="search" placeholder="Search" class="form-control">
                    </div>
                    <div class="my-2">
                        <select name="" class="form-select" id="">
                            <option value="" disabled selected>Pilih Status</option>
                            <option value=""></option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
        <div class="my-2 d-flex">
            <div class="col-3">
                <div class="p-4 bg-white rounded min-vh-100 max-vh-100 overflow-auto">
                    <div class="my-2">
                        <h6 class="fw-semibold">Daftar Approval</h6>
                    </div>
                    <div class="list-group list-group-flush" role="tablist" id="tablist">
                        @if ($approval->isEmpty())
                            @include('component.empty', ['message' => 'Belum Ada Approval'])
                        @else
                            @foreach ($approval as $item)
                                <a href="" type="button" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#tab-{{ $item->id }}" class="list-group-item p-2 d-flex rounded"
                                    aria-controls="{{ $item->id }}">
                                    <div class="col-9 mx-2">
                                        <h6 class="fw-semibold my-2">{{ $item->nama_perusahaan }}</h6>
                                        <ul class="list-unstyled">

                                        </ul>
                                    </div>
                                    <div class="col-3">
                                        <h6>{{ $item->status }}</h6>
                                    </div>
                                </a>
                            @endforeach
                        @endif
                    </div>
                    <div>

                    </div>
                </div>
            </div>
            <div class="col-9 mx-2">
                <div class="p-4 bg-white rounded min-vh-100 max-vh-100 overflow-auto">

                </div>
            </div>
        </div>
    </div>
@endsection
