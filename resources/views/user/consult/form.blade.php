@extends('layouts.app')

@section('content')
    <div class="container p-4">
        <div class="bg-white p-4 rounded min-vh-50">
            <h2 class="text-center p-2">Form Pendaftaran Konseling</h2>
            <div class="p-2 mb-3">

            </div>
            <form action="/create-appointment" method="POST">
                @csrf
                <div class="mb-3 row">
                    <label for="" class="col-sm-2 col-form-label">Topik</label>
                    <div class="col-lg-10">
                        <select class="form-select" aria-label="Default select example" name="topik" required>
                            <option selected>Topik Konseling</option>
                            <option value="Menulis CV dan Surat Lamaran">Menulis CV dan Surat Lamaran</option>
                            <option value="Menghadapi Psikotes">Menghadapi Psikotes</option>
                            <option value="Menghadapi LGD">Menghadapi LGD</option>
                            <option value="Menghadapi Wawancara Kerja">Menghadapi Wawancara Kerja</option>
                            <option value="Menghadapi Kehidupan Kerja">Menghadapi Kehidupan Kerja</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="" class="col-form-label col-lg-2">Jenis Konseling</label>
                    <div class="col-lg-10">
                        <select class="form-select" aria-label="Default select example" name="jenis_konseling" required>
                            <option selected>Jenis Konseling</option>
                            <option value="individu">individu</option>
                            <option value="kelompok">kelompok</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="" class="col-form-label col-lg-2">Tanggal Konseling</label>
                    <div class="col-lg-10">
                        <input type="date" class="form-control" id="" name="tanggal_konseling" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="" class="col-form-label col-lg-2">Jam Konseling</label>
                    <div class="col-lg-10">
                        <select class="form-select" name="jam_konseling" required>
                            <option selected>Pilih Jam Konseling</option>
                            <option value="09:00">09.00</option>
                            <option value="10:00">10.00</option>
                            <option value="11:00">11.00</option>
                            <option value="12:00">12.00</option>
                            <option value="13:00">13.00</option>
                            <option value="14:00">14.00</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <button class=" col-lg-8 offset-2 btn btn-primary ">Submit</button>
                </div>

            </form>
        </div>

    </div>
@endsection
