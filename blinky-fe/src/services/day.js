export default class DayFormatter{
    constructor(day){
        this.day = day;
    }

    convertToDayName(){
        let hari = this.day;

        switch(hari) {
            case 1: hari = "Senin"; break;
            case 2: hari = "Selasa"; break;
            case 3: hari = "Rabu"; break;
            case 4: hari = "Kamis"; break;
            case 5: hari = "Jumat"; break;
            case 6: hari = "Sabtu"; break;
        }

        return hari;
    }
}