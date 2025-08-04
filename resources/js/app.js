import './bootstrap';
import Alpine from 'alpinejs';

// Impor FullCalendar
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import timeGridPlugin from '@fullcalendar/timegrid'; // Tambahan untuk tampilan mingguan/harian
import listPlugin from '@fullcalendar/list';       // Tambahan untuk tampilan daftar

// Impor Bootstrap JS untuk Tooltip jika digunakan (pastikan sudah npm install bootstrap)
import * as bootstrap from 'bootstrap';

window.Alpine = Alpine;
Alpine.start();

// Inisialisasi Kalender
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    if (calendarEl) { // Pastikan elemen kalender ada
        var calendar = new Calendar(calendarEl, {
            plugins: [ dayGridPlugin, interactionPlugin, timeGridPlugin, listPlugin ], // Tambahkan plugin
            initialView: 'dayGridMonth', // Tampilan awal bulanan
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek' // Pilihan tampilan: Bulan, Minggu, Hari, Daftar
            },
            locale: 'id', // Atur bahasa kalender ke Indonesia
            buttonText: {
                today: 'Hari Ini',
                month: 'Bulan',
                week: 'Minggu',
                day: 'Hari',
                list: 'Daftar'
            },
            events: function(fetchInfo, successCallback, failureCallback) {
                // Ambil ID karyawan dari dropdown
                let karyawanSelect = document.getElementById('karyawan_select');
                let karyawanId = karyawanSelect ? karyawanSelect.value : null;

                if (!karyawanId) {
                    successCallback([]); // Jika belum ada karyawan dipilih, tampilkan kalender kosong
                    return;
                }

                // Panggil API backend untuk mendapatkan data event
                fetch('/absensi/get-events?karyawan_id=' + karyawanId + '&start=' + fetchInfo.startStr + '&end=' + fetchInfo.endStr, { // Pastikan fetchInfo.endStr
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    let events = data.map(event => {
                        let title = '';
                        let color = '';
                        let icon = '';

                        // Logika penentuan title, color, dan icon berdasarkan status_kehadiran
                        switch(event.status_kehadiran) {
                            case 'hadir': title = 'Hadir'; color = '#34D399'; icon = '✓'; break;
                            case 'izin': title = 'Izin'; color = '#60A5FA'; icon = '📝'; break;
                            case 'sakit': title = 'Sakit'; color = '#FCD34D'; icon = '🤒'; break;
                            case 'alpa': title = 'Alpa'; color = '#EF4444'; icon = '❌'; break;
                            case 'libur': title = 'Libur'; color = '#9CA3AF'; icon = '🏖️'; break;
                            case 'cuti': title = 'Cuti'; color = '#A855F7'; icon = '⭐'; break;
                            default: title = event.status_kehadiran || 'N/A'; color = '#D1D5DB'; icon = '';
                        }

                        return {
                            id: event.id,
                            title: icon + ' ' + title, // Gabungkan ikon dan teks status
                            start: event.start, // Tanggal start dari API
                            end: event.end,     // Tanggal end dari API
                            allDay: true,       // Event sehari penuh
                            backgroundColor: color,
                            borderColor: color,
                            textColor: '#FFFFFF', // Teks putih di atas warna
                            extendedProps: { // Untuk menyimpan data tambahan jika diperlukan
                                status: event.status_kehadiran,
                                catatan: event.catatan,
                                waktu_masuk: event.waktu_masuk,
                                waktu_keluar: event.waktu_keluar,
                            }
                        };
                    });
                    successCallback(events);
                })
                .catch(error => {
                    console.error("Error fetching events:", error);
                    failureCallback(error);
                });
            },
            // Event click handler for showing more details (jika menggunakan Bootstrap Tooltip)
            eventDidMount: function(info) {
                const masuk = info.event.extendedProps.waktu_masuk || '-';
                const keluar = info.event.extendedProps.waktu_keluar || '-';
                const catatan = info.event.extendedProps.catatan || '';

                // Pastikan bootstrap.Tooltip tersedia (jika npm install bootstrap)
                if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
                    new bootstrap.Tooltip(info.el, {
                        title: `Masuk: ${masuk} | Keluar: ${keluar} | Catatan: ${catatan}`,
                        placement: 'top',
                        trigger: 'hover',
                        container: 'body'
                    });
                } else {
                    // Fallback jika Bootstrap Tooltip tidak dimuat
                    info.el.title = `Masuk: ${masuk} | Keluar: ${keluar} | Catatan: ${catatan}`;
                }
            },
            // Optional: Event click handler for showing more details (jika tidak pakai Bootstrap Tooltip)
            eventClick: function(info) {
                let eventData = info.event.extendedProps;
                let dialogMessage = `Status: ${eventData.status ? eventData.status.toUpperCase() : 'N/A'}` +
                                    `\nTanggal: ${info.event.start.toLocaleDateString()}` +
                                    `\nMasuk: ${eventData.waktu_masuk || '-'}` +
                                    `\nKeluar: ${eventData.waktu_keluar || '-'}` +
                                    `\nCatatan: ${eventData.catatan || '-'}`;
                // alert(dialogMessage); // Bisa diaktifkan jika ingin alert
            },
            dateClick: function(info) {
                // Optional: Anda bisa mengarahkan ke form tambah absensi untuk tanggal ini
                // window.location.href = '/absensi/create?date=' + info.dateStr;
            }
        });

        calendar.render();

        // Event listener untuk dropdown karyawan
        // Ketika karyawan dipilih, muat ulang event di kalender
        document.getElementById('karyawan_select')?.addEventListener('change', function() {
            calendar.refetchEvents(); // Perintah untuk memuat ulang event
        });
    }
});