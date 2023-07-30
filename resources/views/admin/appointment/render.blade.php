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
