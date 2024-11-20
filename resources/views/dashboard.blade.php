@extends('layout.layout')
@section('main')
    <div class="col-md-12 col-lg-12">
        <div class="row row-cols-1">
            <div class="overflow-hidden d-slider1">
                <ul class="p-0 m-0 mb-2 swiper-wrapper list-inline">
                    @if ($absen && $absen->status === null && now()->addHours(7)->between('07:00', '09:00') && $absen->masuk < now())
                        <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
                            <div class="card-body">
                                <div class="progress-widget">
                                    <form action="/masuk" method="POST">
                                        @csrf
                                        <button type="submit" class="btn" id="attendance-btn">Absen</button>
                                    </form>
                                    <div class="progress-detail">
                                        <p class="mb-2">Absen</p>
                                        <h4 class="counter" id="attendance-status">Nothing</h4>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                    @if (
                        $absen &&
                            in_array($absen->status, ['Hadir', 'Terlambat']) &&
                            now()->addHours(7)->hour >= 23 &&
                            $absen->keluar === null)
                        <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="800">
                            <div class="card-body">
                                <div class="progress-widget">
                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                        data-bs-target="#staticBackdrop">Absen</button>
                                    <div class="progress-detail">
                                        <p class="mb-2">Absen Keluar</p>
                                        <h4 class="counter">Keluar</h4>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                    @if ($absen && $absen->keluar !== null)
                        <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="900">
                            <div class="card-body">
                                <div class="progress-widget">
                                    <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                        data-bs-target="#staticBackdrop">Absen Sendiri</button>
                                    <div class="progress-detail">
                                        <p class="mb-2">Absen Keluar</p>
                                        <h4 class="counter">Keluar</h4>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
                </ul>
                <div class="swiper-button swiper-button-next"></div>
                <div class="swiper-button swiper-button-prev"></div>
            </div>
        </div>

        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Absen Keluar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="/keluar">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="kegiatan" class="form-label">Kegiatan</label>
                                <textarea class="form-control" style="width: 100%; height: 150px;" id="kegiatan" name="kegiatan"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Absen</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateAttendanceStatus() {
            const attendanceButton = document.getElementById('attendance-btn');
            const attendanceStatus = document.getElementById('attendance-status');
            const currentHour = now().addHours(7).hour;

            if (currentHour >= 7 && currentHour < 9) {
                attendanceButton.classList.add('btn-outline-primary');
                attendanceButton.classList.remove('btn-outline-danger', 'btn-secondary');
                attendanceStatus.textContent = 'Hadir';
            } else if (currentHour >= 9 && currentHour < 12) {
                attendanceButton.classList.add('btn-outline-danger');
                attendanceButton.classList.remove('btn-outline-primary', 'btn-secondary');
                attendanceStatus.textContent = 'Telat';
            }
        }
        updateAttendanceStatus();
    </script>
@endsection
