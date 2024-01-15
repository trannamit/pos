function convertTimeStamp(timestamp, string) {
    let cD = "-";
    let cT = ":";
    if(timestamp == null || timestamp == ''){
        return ;
    }
    if (timestamp.length != 19 ) {
        return ;
    }
    let str = timestamp.split("");
    

    let year = str[0] + str[1] + str[2] + str[3];
    let month = str[5] + str[6];
    let day = str[8] + str[9];
    let hours = str[11] + str[12];
    let min = str[14] + str[15];
    let sec = str[17] + str[18];

    if (string == null || string == "") {
        return hours + cT + min + cT + sec + " " + day + cD + month + cD + year;
    } else {
        let arrFormat = string.split("");
        let result = "";
        arrFormat.forEach(function (d) {
            if (d == "Y") {
                d = year;
            }
            if (d == "M") {
                d = month;
            }
            if (d == "D") {
                d = day;
            }
            if (d == "h") {
                d = hours;
            }
            if (d == "m") {
                d = min;
            }
            if (d == "s") {
                d = sec;
            }
            result += d;
        });
        return result;
    }
}