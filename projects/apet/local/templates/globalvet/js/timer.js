window.onload = function() // дожидаемся загрузки страницы
{
    initializeTimer(); // вызываем функцию инициализации таймера
};

function initializeTimer() {
    var seconds = (endDate-currentDate); // определяем количество секунд до истечения таймера
    if (seconds > 0) { // проверка - истекла ли дата обратного отсчета
        var minutes = seconds/60; // определяем количество минут до истечения таймера
        var hours = minutes/60; // определяем количество часов до истечения таймера
        var days = hours/24; // определяем количество дней до истечения таймера
        minutes = (hours - Math.floor(hours)) * 60; // подсчитываем кол-во оставшихся минут в текущем часе
        hours = Math.floor((days - Math.floor(days)) * 24); // целое количество часов до истечения таймера
        days = Math.floor(days); // целое количество часов до истечения таймера
        seconds = Math.floor((minutes - Math.floor(minutes)) * 60); // подсчитываем кол-во оставшихся секунд в текущей минуте
        minutes = Math.floor(minutes); // округляем до целого кол-во оставшихся минут в текущем часе

        setTimePage(days,hours,minutes,seconds); // выставляем начальные значения таймера

        function secOut() {
            if (seconds == 0) { // если секунду закончились то
                if (minutes == 0) { // если минуты закончились то
                    if (hours == 0) { // если часы закончились то
                        if (days == 0) { // если дни закончились то
                            showMessage(timerId); // выводим сообщение об окончании отсчета
                        }
                        else {
                            days--; // уменьшаем кол-во дней
                            hours = 23; // обновляем часы
                            minutes = 59; // обновляем минуты
                            seconds = 59; // обновляем секунды
                        }
                    }
                    else {
                        hours--; // уменьшаем кол-во часов
                        minutes = 59; // обновляем минуты
                        seconds = 59; // обновляем секунды
                    }
                }
                else {
                    minutes--; // уменьшаем кол-во минут
                    seconds = 59; // обновляем секунды
                }
            }
            else {
                seconds--; // уменьшаем кол-во секунд
            }
            setTimePage(days,hours,minutes,seconds); // обновляем значения таймера на странице
        }
        timerId = setInterval(secOut, 1000) // устанавливаем вызов функции через каждую секунду
    }
    else {
        days = 0;
        hours = 0;
        minutes = 0;
        seconds = 0;
        setTimePage(days,hours,minutes,seconds);
    }
}

function setTimePage(d,h,m,s) { // функция выставления таймера на странице
    $('.js-timer-day').text(d);
    $('.js-timer-hour').text(h);
    $('.js-timer-min').text(m);
    $('.js-timer-sec').text(s);
}

function showMessage(timerId) { // функция, вызываемая по истечению времени
    clearInterval(timerId); // останавливаем вызов функции через каждую секунду
}
