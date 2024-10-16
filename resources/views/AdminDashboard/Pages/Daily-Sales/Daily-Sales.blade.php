@extends('AdminDashboard.Particals.app')
@section('title', 'Daily Sales Report Page')
@section('content')
    <style>
        .fc-event,
        .fc-event-dot {
            background-color: white;
        }

        .fc-event {
            position: relative;
            display: block;
            font-size: .85em;
            line-height: 1.3;
            border-radius: 3px;
            border: 1px solid black;
        }

        .fc-title {
            color: black;
        }

        #calendar {
            max-width: 90%;
            margin: 40px auto;
            padding: 0 10px;
        }

        .sales-table {
            width: 50%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        .sales-table th,
        .sales-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .sales-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .total-grand {
            font-weight: bold;
        }

        .sales-table {
            width: 100%;
            margin-top: 5px;
            margin-bottom: 5px;
            border-collapse: collapse;
        }

        .sales-table th,
        .sales-table td {
            padding: 5px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .sales-table th {
            background-color: #f9f9f9;
        }

        .sales-table td {
            background-color: #fff;
        }
    </style>

    <div class="layout-wrapper layout-content-navbar">

        <div class="layout-container">

            @include('AdminDashboard.Layouts.Sidenavbar')

            <div class="layout-page">

                @include('AdminDashboard.Layouts.header')

                <div class="content-wrapper">

                    <div id="calendar"></div>

                    <script>
                        $(document).ready(function() {
                            $('#calendar').fullCalendar({
                                header: {
                                    left: 'prev,next',
                                    center: 'title',
                                    right: 'month,basicWeek,basicDay'
                                },
                                defaultDate: new Date(),
                                navLinks: true,
                                editable: true,
                                eventLimit: true,

                                events: function(start, end, timezone, callback) {
                                    let startDate = moment(start).format('YYYY-MM-DD');
                                    let endDate = moment(end).format('YYYY-MM-DD');

                                    $.ajax({
                                        url: '{{ route('fetch.sales', '') }}',
                                        data: {
                                            start: startDate,
                                            end: endDate
                                        },
                                        success: function(data) {
                                            let events = [];

                                            $.each(data.salesData, function(index, salesData) {
                                                events.push({
                                                    title: '',
                                                    start: salesData.date,
                                                    allDay: true,
                                                    salesInfo: salesData
                                                });
                                            });

                                            callback(events);

                                        },
                                        error: function(error) {
                                            console.log('Error fetching sales data:', error);
                                        }
                                    });
                                },

                                eventRender: function(event, element) {
                                    if (event.salesInfo) {
                                        let salesTable = `
                                        <table class="sales-table">
                                            <thead>
                                                <tr>
                                                    <th>Bill No.</th>
                                                    <th>Grand Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>`;

                                        $.each(event.salesInfo.bills, function(i, bill) {
                                            salesTable += `
                                                <tr>
                                                    <td>${bill.bill_no}</td>
                                                    <td>₹${bill.total.toFixed(2)}</td>
                                                </tr>`;
                                        });

                                        salesTable += `
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td><strong>Date Total</strong></td>
                                                    <td><strong>₹${event.salesInfo.total.toFixed(2)}</strong></td>
                                                </tr>
                                            </tfoot>
                                        </table>`;

                                        $(element).find('.fc-content').append(salesTable);
                                    }
                                }
                            });
                        });
                    </script>


                    @include('AdminDashboard.Layouts.footer')
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>
        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>
@endsection
