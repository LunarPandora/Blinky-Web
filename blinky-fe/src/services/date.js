export default class DateFormatter {
    constructor(date){
        if(date != 0){
            this.defaultDate = new Date(date)

            this.tahun = this.defaultDate.getFullYear();
            this.bulan = this.defaultDate.getMonth();
            this.tanggal = this.defaultDate.getDate();
            this.hari = this.defaultDate.getDay();
            this.jam = this.defaultDate.getHours();
            this.menit = this.defaultDate.getMinutes();
            this.detik = this.defaultDate.getSeconds();
        }
        else{
            this.defaultDate = 'NaN';
        }
    }

    addZero(i) {
        if (i < 10) {i = "0" + i}
        return i;
    }

    format(withJam = true){
        if(this.defaultDate != 'NaN'){
            let hari = this.hari
            let bulan = this.bulan
    
            switch(hari) {
                case 0: hari = "Minggu"; break;
                case 1: hari = "Senin"; break;
                case 2: hari = "Selasa"; break;
                case 3: hari = "Rabu"; break;
                case 4: hari = "Kamis"; break;
                case 5: hari = "Jumat"; break;
                case 6: hari = "Sabtu"; break;
            }
        
            switch(bulan) {
                case 0: bulan = "Januari"; break;
                case 1: bulan = "Februari"; break;
                case 2: bulan = "Maret"; break;
                case 3: bulan = "April"; break;
                case 4: bulan = "Mei"; break;
                case 5: bulan = "Juni"; break;
                case 6: bulan = "Juli"; break;
                case 7: bulan = "Agustus"; break;
                case 8: bulan = "September"; break;
                case 9: bulan = "Oktober"; break;
                case 10: bulan = "November"; break;
                case 11: bulan = "Desember"; break;
            }
    
            let tampilTanggal = hari + ", " + this.tanggal + " " + bulan + " " + this.tahun;
            let tampilWaktu = this.addZero(this.jam) + ":" + this.addZero(this.menit);
    
            if(withJam){
                return tampilTanggal + " - " + tampilWaktu
            }
            else{
                return tampilTanggal
            }
        }
        else{
            return 'Tanggal tidak diketahui.'
        }
    }
}