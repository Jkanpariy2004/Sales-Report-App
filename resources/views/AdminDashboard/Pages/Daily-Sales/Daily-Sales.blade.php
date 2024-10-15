@extends('AdminDashboard.Particals.app')

@section('title', 'Daily Sales Report Page')

@section('content')
    <style>
        :root {
            --primary-clr: #7367f0;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-clr);
            border-radius: 50px;
        }

        .container {
            position: relative;
            width: 1200px;
            min-height: 850px;
            margin: 0 auto;
            padding: 5px;
            color: #fff;
            display: flex;

            border-radius: 10px;
        }

        .left {
            width: 70%;
            padding: 20px;
        }

        .calendar {
            position: relative;
            width: 100%;
            /* height: 100%; */
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            justify-content: space-between;
            color: #878895;
            border-radius: 5px;
            background-color: #fff;
        }

        .calendar .month {
            width: 100%;
            /* height: 150px; */
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 50px;
            font-size: 1.2rem;
            font-weight: 500;
            text-transform: capitalize;
            margin-top: 30px;
        }

        .calendar .month .prev,
        .calendar .month .next {
            cursor: pointer;
        }

        .calendar .month .prev:hover,
        .calendar .month .next:hover {
            color: var(--primary-clr);
        }

        .calendar .weekdays {
            width: 100%;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            font-size: 1rem;
            font-weight: 500;
            text-transform: capitalize;
        }

        .weekdays div {
            width: 14.28%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .calendar .days {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 0 20px;
            font-size: 1rem;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .calendar .days .day {
            width: 14.28%;
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--primary-clr);
            border: 1px solid #f5f5f5;
        }

        .calendar .days .day:nth-child(7n + 1) {
            border-left: 2px solid #f5f5f5;
        }

        .calendar .days .day:nth-child(7n) {
            border-right: 2px solid #f5f5f5;
        }

        .calendar .days .day:nth-child(-n + 7) {
            border-top: 2px solid #f5f5f5;
        }

        .calendar .days .day:nth-child(n + 29) {
            border-bottom: 2px solid #f5f5f5;
        }

        .calendar .days .prev-date,
        .calendar .days .next-date {
            color: #b3b3b3;
        }

        .calendar .days .active {
            position: relative;
            font-size: 2rem;
            color: #fff;
            background-color: var(--primary-clr);
        }

        .calendar .days .active::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            box-shadow: 0 0 10px 2px var(--primary-clr);
        }

        .calendar .days .today {
            /* Removed today styles */
            /* font-size: 2rem; */
        }

        .calendar .days .event {
            position: relative;
        }

        .calendar .days .event::after {
            content: "";
            position: absolute;
            bottom: 10%;
            left: 50%;
            width: 75%;
            height: 6px;
            border-radius: 30px;
            transform: translateX(-50%);
            background-color: var(--primary-clr);
        }

        .calendar .days .day:hover.event::after {
            background-color: #fff;
        }

        .calendar .days .active.event::after {
            background-color: #fff;
            bottom: 20%;
        }

        .calendar .days .active.event {
            padding-bottom: 10px;
        }

        .calendar .goto-today {
            width: 100%;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 5px;
            padding: 0 20px;
            margin-bottom: 20px;
            color: var(--primary-clr);
        }

        .calendar .goto-today .goto {
            display: flex;
            align-items: center;
            border-radius: 5px;
            overflow: hidden;
            border: 1px solid var(--primary-clr);
        }

        .calendar .goto-today .goto input {
            width: 100%;
            height: 30px;
            outline: none;
            border: none;
            border-radius: 5px;
            padding: 0 20px;
            color: var(--primary-clr);
            border-radius: 5px;
        }

        .calendar .goto-today button {
            padding: 5px 10px;
            border: 1px solid var(--primary-clr);
            border-radius: 5px;
            background-color: transparent;
            cursor: pointer;
            color: var(--primary-clr);
        }

        .calendar .goto-today button:hover {
            color: #fff;
            background-color: var(--primary-clr);
        }

        .calendar .goto-today .goto button {
            border: none;
            border-left: 1px solid var(--primary-clr);
            border-radius: 0;
        }

        .container .right {
            position: relative;
            width: 40%;
            min-height: 100%;
            padding: 20px 0;
        }

        .right .today-date {
            width: 100%;
            height: 50px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
            justify-content: space-between;
            padding: 0 40px;
            padding-left: 70px;
            margin-top: 50px;
            margin-bottom: 20px;
            text-transform: capitalize;
        }

        .right .today-date .event-day {
            font-size: 2rem;
            font-weight: 500;
        }

        .right .today-date .event-date {
            font-size: 1rem;
            font-weight: 400;
            color: #878895;
        }

        .events {
            width: 100%;
            height: 100%;
            max-height: 600px;
            overflow-x: hidden;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            padding-left: 4px;
        }

        .events .event {
            position: relative;
            width: 95%;
            min-height: 70px;
            display: flex;
            justify-content: center;
            flex-direction: column;
            gap: 5px;
            padding: 0 20px;
            padding-left: 50px;
            color: #fff;
            background: linear-gradient(90deg, #3f4458, transparent);
            cursor: pointer;
        }

        /* even event */
        .events .event:nth-child(even) {
            background: transparent;
        }

        .events .event:hover {
            background: linear-gradient(90deg, var(--primary-clr), transparent);
        }

        .events .event .title {
            display: flex;
            align-items: center;
            pointer-events: none;
        }

        .events .event .title .event-title {
            font-size: 1rem;
            font-weight: 400;
            margin-left: 20px;
        }

        .events .event i {
            color: var(--primary-clr);
            font-size: 0.5rem;
        }

        .events .event:hover i {
            color: #fff;
        }

        .events .event .event-time {
            font-size: 0.8rem;
            font-weight: 400;
            color: #878895;
            margin-left: 15px;
            pointer-events: none;
        }

        .events .event:hover .event-time {
            color: #fff;
        }

        /* add tick in event after */
        .events .event::after {
            content: "✓";
            position: absolute;
            top: 50%;
            right: 0;
            font-size: 3rem;
            line-height: 1;
            display: none;
            align-items: center;
            justify-content: center;
            opacity: 0.3;
            color: var(--primary-clr);
            transform: translateY(-50%);
        }

        .events .event:hover::after {
            display: flex;
        }

        .add-event {
            position: absolute;
            bottom: 30px;
            right: 30px;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: #878895;
            border: 2px solid #878895;
            opacity: 0.5;
            border-radius: 50%;
            background-color: transparent;
            cursor: pointer;
        }

        .add-event:hover {
            opacity: 1;
        }

        .add-event i {
            pointer-events: none;
        }

        .events .no-event {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 500;
            color: #878895;
        }

        .add-event-wrapper {
            position: absolute;
            bottom: 100px;
            left: 50%;
            width: 90%;
            max-height: 0;
            overflow: hidden;
            border-radius: 5px;
            background-color: #fff;
            transform: translateX(-50%);
            transition: max-height 0.5s ease;
        }

        .add-event-wrapper.active {
            max-height: 300px;
        }

        .add-event-header {
            width: 100%;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            color: #373c4f;
            border-bottom: 1px solid #f5f5f5;
        }

        .add-event-header .close {
            font-size: 1.5rem;
            cursor: pointer;
        }

        .add-event-header .close:hover {
            color: var(--primary-clr);
        }

        .add-event-header .title {
            font-size: 1.2rem;
            font-weight: 500;
        }

        .add-event-body {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            gap: 5px;
            padding: 20px;
        }

        .add-event-body .add-event-input {
            width: 100%;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .add-event-body .add-event-input input {
            width: 100%;
            height: 100%;
            outline: none;
            border: none;
            border-bottom: 1px solid #f5f5f5;
            padding: 0 10px;
            font-size: 1rem;
            font-weight: 400;
            color: #373c4f;
        }

        .add-event-body .add-event-input input::placeholder {
            color: #a5a5a5;
        }

        .add-event-body .add-event-input input:focus {
            border-bottom: 1px solid var(--primary-clr);
        }

        .add-event-body .add-event-input input:focus::placeholder {
            color: var(--primary-clr);
        }

        .add-event-footer {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .add-event-footer .add-event-btn {
            height: 40px;
            font-size: 1rem;
            font-weight: 500;
            outline: none;
            border: none;
            color: #fff;
            background-color: var(--primary-clr);
            border-radius: 5px;
            cursor: pointer;
            padding: 5px 10px;
            border: 1px solid var(--primary-clr);
        }

        .add-event-footer .add-event-btn:hover {
            background-color: transparent;
            color: var(--primary-clr);
        }

        /* media queries */

        @media screen and (max-width: 1000px) {
            body {
                align-items: flex-start;
                justify-content: flex-start;
            }

            .container {
                min-height: 100vh;
                flex-direction: column;
                border-radius: 0;
            }

            .container .left {
                width: 100%;
                height: 100%;
                padding: 20px 0;
            }

            .container .right {
                width: 100%;
                height: 100%;
                padding: 20px 0;
            }

            .calendar::before,
            .calendar::after {
                top: 100%;
                left: 50%;
                width: 97%;
                height: 12px;
                border-radius: 0 0 5px 5px;
                transform: translateX(-50%);
            }

            .calendar::before {
                width: 94%;
                top: calc(100% + 12px);
            }

            .events {
                padding-bottom: 340px;
            }

            .add-event-wrapper {
                bottom: 100px;
            }
        }

        @media screen and (max-width: 500px) {
            .calendar .month {
                height: 75px;
            }

            .calendar .weekdays {
                height: 50px;
            }

            .calendar .days .day {
                height: 40px;
                font-size: 0.8rem;
            }

            .calendar .days .day.active,
            .calendar .days .day.today {
                font-size: 1rem;
            }

            .right .today-date {
                padding: 20px;
            }
        }

        /* .credits {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #fff;
            background-color: #b38add;
        }

        .credits a {
            text-decoration: none;
            font-weight: 600;
        }

        .credits a:hover {
            text-decoration: underline;
        } */
    </style>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            @include('AdminDashboard.Layouts.Sidenavbar')

            <div class="layout-page">

                @include('AdminDashboard.Layouts.header')

                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container">
                        <div class="left">
                            <div class="calendar">
                                <div class="month">
                                    <i class="fas fa-angle-left prev"></i>
                                    <div class="date">december 2015</div>
                                    <i class="fas fa-angle-right next"></i>
                                </div>
                                <div class="weekdays">
                                    <div>Sun</div>
                                    <div>Mon</div>
                                    <div>Tue</div>
                                    <div>Wed</div>
                                    <div>Thu</div>
                                    <div>Fri</div>
                                    <div>Sat</div>
                                </div>
                                <div class="days"></div>
                                <div class="goto-today">
                                    <button class="today-btn">Today</button>
                                </div>
                            </div>
                        </div>
                        <div class="right">
                            <div class="today-date">
                                <div class="event-day text-dark">${dayName}</div>
                                <div class="event-date">${date} ${months[month]} ${year}</div>
                            </div>
                            <div class="events"></div>
                        </div>
                    </div>

                    <script>
                        const calendar = document.querySelector(".calendar"),
                            date = document.querySelector(".date"),
                            daysContainer = document.querySelector(".days"),
                            prev = document.querySelector(".prev"),
                            next = document.querySelector(".next"),
                            dateInput = document.querySelector(".date-input"),
                            eventDay = document.querySelector(".event-day"),
                            eventDate = document.querySelector(".event-date"),
                            eventsContainer = document.querySelector(".events"),
                            addEventBtn = document.querySelector(".add-event"),
                            addEventWrapper = document.querySelector(".add-event-wrapper "),
                            addEventCloseBtn = document.querySelector(".close "),
                            addEventTitle = document.querySelector(".event-name "),
                            addEventFrom = document.querySelector(".event-time-from "),
                            addEventTo = document.querySelector(".event-time-to "),
                            addEventSubmit = document.querySelector(".add-event-btn ");

                        let today = new Date();
                        let activeDay;
                        let month = today.getMonth();
                        let year = today.getFullYear();

                        const months = [
                            "January",
                            "February",
                            "March",
                            "April",
                            "May",
                            "June",
                            "July",
                            "August",
                            "September",
                            "October",
                            "November",
                            "December",
                        ];

                        const eventsArr = [];
                        getEvents();

                        function initCalendar() {
                            const firstDay = new Date(year, month, 1);
                            const lastDay = new Date(year, month + 1, 0);
                            const prevLastDay = new Date(year, month, 0);
                            const prevDays = prevLastDay.getDate();
                            const lastDate = lastDay.getDate();
                            const day = firstDay.getDay();
                            const nextDays = 7 - lastDay.getDay() - 1;

                            date.innerHTML = months[month] + " " + year;

                            let days = "";

                            for (let x = day; x > 0; x--) {
                                days += `<div class="day prev-date">${prevDays - x + 1}</div>`;
                            }

                            for (let i = 1; i <= lastDate; i++) {
                                //check if event is present on that day
                                let event = false;
                                eventsArr.forEach((eventObj) => {
                                    if (
                                        eventObj.day === i &&
                                        eventObj.month === month + 1 &&
                                        eventObj.year === year
                                    ) {
                                        event = true;
                                    }
                                });
                                if (
                                    i === new Date().getDate() &&
                                    year === new Date().getFullYear() &&
                                    month === new Date().getMonth()
                                ) {
                                    activeDay = i;
                                    getActiveDay(i);
                                    updateEvents(i);
                                    if (event) {
                                        days += `<div class="day today active event">${i}</div>`;
                                    } else {
                                        days += `<div class="day today active">${i}</div>`;
                                    }
                                } else {
                                    if (event) {
                                        days += `<div class="day event">${i}</div>`;
                                    } else {
                                        days += `<div class="day ">${i}</div>`;
                                    }
                                }
                            }

                            for (let j = 1; j <= nextDays; j++) {
                                days += `<div class="day next-date">${j}</div>`;
                            }
                            daysContainer.innerHTML = days;
                            addListner();
                        }

                        function prevMonth() {
                            month--;
                            if (month < 0) {
                                month = 11;
                                year--;
                            }
                            initCalendar();
                        }

                        function nextMonth() {
                            month++;
                            if (month > 11) {
                                month = 0;
                                year++;
                            }
                            initCalendar();
                        }

                        prev.addEventListener("click", prevMonth);
                        next.addEventListener("click", nextMonth);

                        initCalendar();

                        function addListner() {
                            const days = document.querySelectorAll(".day");
                            days.forEach((day) => {
                                day.addEventListener("click", (e) => {
                                    getActiveDay(e.target.innerHTML);
                                    updateEvents(Number(e.target.innerHTML));
                                    activeDay = Number(e.target.innerHTML);

                                    days.forEach((day) => {
                                        day.classList.remove("active");
                                    });

                                    if (e.target.classList.contains("prev-date")) {
                                        prevMonth();

                                        setTimeout(() => {

                                            const days = document.querySelectorAll(".day");
                                            days.forEach((day) => {
                                                if (
                                                    !day.classList.contains("prev-date") &&
                                                    day.innerHTML === e.target.innerHTML
                                                ) {
                                                    day.classList.add("active");
                                                }
                                            });
                                        }, 100);
                                    } else if (e.target.classList.contains("next-date")) {
                                        nextMonth();

                                        setTimeout(() => {
                                            const days = document.querySelectorAll(".day");
                                            days.forEach((day) => {
                                                if (
                                                    !day.classList.contains("next-date") &&
                                                    day.innerHTML === e.target.innerHTML
                                                ) {
                                                    day.classList.add("active");
                                                }
                                            });
                                        }, 100);
                                    } else {
                                        e.target.classList.add("active");
                                    }
                                });
                            });
                        }

                        function getActiveDay(date) {
                            const day = new Date(year, month, date);
                            const dayName = day.toString().split(" ")[0];
                            eventDay.innerHTML = dayName;
                            eventDate.innerHTML = date + " " + months[month] + " " + year;
                        }

                        function fetchSalesData(date) {
                            return fetch(`/admin/reports/daily-sales/sales/${year}-${month + 1}-${date}`)
                                .then(response => response.json())
                                .catch(error => console.error('Error fetching sales data:', error));
                        }

                        async function updateEvents(date) {
                            let events = "";
                            const salesData = await fetchSalesData(date);

                            if (salesData && salesData.length > 0) {
                                salesData.forEach(sale => {
                                    events += `<div class="event">
                                        <div class="title">
                                            <i class="fas fa-circle"></i>
                                            <h3 class="event-title">${sale.bill_no}</h3>
                                        </div>
                                        <div class="event-time">
                                            <span class="event-time">${sale.grand_total}</span>
                                        </div>
                                    </div>`;
                                });
                            } else {
                                // Update the message to indicate no sales available
                                events = `<div class="no-event">
                                    <h3>No Sales Available for ${date} ${months[month]} ${year}</h3>
                                </div>`;
                            }
                            eventsContainer.innerHTML = events;
                            saveEvents();
                        }

                        function saveEvents() {
                            localStorage.setItem("events", JSON.stringify(eventsArr));
                        }

                        function getEvents() {
                            if (localStorage.getItem("events") === null) {
                                return;
                            }
                            eventsArr.push(...JSON.parse(localStorage.getItem("events")));
                        }

                        const todayBtn = document.querySelector(".today-btn");
                        todayBtn.addEventListener("click", () => {
                            today = new Date();
                            month = today.getMonth();
                            year = today.getFullYear();
                            initCalendar();
                        });
                    </script>
                    <!-- / Content -->

                    @include('AdminDashboard.Layouts.footer')

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
@endsection
