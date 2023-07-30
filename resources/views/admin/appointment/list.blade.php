@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="my-4">
            <div class="bg-white p-4 min-vh-50 max-vh-100 overflow-auto rounded border-1">
                <div class="d-flex my-4 justify-content-between">
                    <h4 class="fw-semibold">Appointment List</h4>
                    <div class="">
                        <input type="text" id="searchTable" onkeyup="searchFunction()" placeholder="Search Name">
                        <div>
                            <input type="checkbox" id="FinishedData" value="pending" onkeydown="finishFunction()">
                            <label for="">Finish</label>
                        </div>
                    </div>
                </div>

                <div class="my-2" id="appointmentsList">
                    <table class="table table-hover">
                        <thead>
                            <th class="text-center">Nama</th>
                            <th class="text-center">Topik</th>
                            <th class="text-center">Tanggal & Waktu</th>
                            <th class="text-center">Nomor Telepon</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Approval</th>
                        </thead>
                        <tbody>
                            @if ($appointments->count() == 0)
                                <tr class="fw-semibold">
                                    <td colspan="6">
                                        <h3 class="fw-semibold text-center">Tidak Ada Appointment</h3>
                                    </td>
                                </tr>
                            @else
                                @foreach ($appointments as $item)
                                    <tr>
                                        <td class="text-center">{{ $item->user->nama_lengkap }}</td>
                                        <td class="text-center">{{ $item->topik }}</td>
                                        <td class="text-center">{{ $item->date_time }}</td>
                                        <td class="text-center">{{ $item->user->nomor_telepon }}</td>
                                        <td class="text-center">{{ $item->status }}</td>
                                        <td class="d-flex justify-content-center">
                                            @if ($item->status === 'Approved')
                                                <button class="btn btn-danger" type="button" data-bs-toggle="modal"
                                                    data-bs-target="#cancelModal">Cancel</button>
                                            @else
                                                <button class="btn btn-warning" type="button" data-bs-toggle="modal"
                                                    data-bs-target="#cancelModal">Cancel</button>
                                                <button class="btn btn-success mx-1" type="button" data-bs-toggle="modal"
                                                    data-bs-target="#approveModal">Approve</button>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>
                    {{ $appointments->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script type="module">
        $(document).ready(function () {
            $(document).on('click','.pagination a', function(e){
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1]
            record(page)
        });

            function record(page){
            $.ajax({
                url:"/render-appointments?page="+page,
                success:function(res){
                    $('#appointmentsList').html(res);
                }
            })
        }

        });

    </script>
    <script>
        function finishFunction() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById('FinishedData');
            filter = input.value;
            table = document.getElementById('appointmentsList');
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[4];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }

        }
    </script>
@endpush
