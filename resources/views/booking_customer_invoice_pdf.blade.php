<!DOCTYPE html>
<html class="loaded " lang="en" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">

    <style>
        table,tr{
            padding:50px;
            width:95%
        }

    </style>
</head>
<body style="font-family: Amiri;direction:rtl">
<table class="dt-multilingual table table-bordered" border=1>
    <thead>
    <tr>
        <th>#</th>
        <th>اسم العميل</th>
        <th>يوم الحجز</th>
        <th>وقت الحجز</th>
    </tr>
    </thead>
    <tbody>
    <tr style="margin-bottom:30px">
        <td>اسم العميل</td>
        <td>{!! $data !!} </td>
    </tr>
        <tr style="margin-bottom:30px">
            <td>يوم الحجز</td>
            <td>{{ $data->booking_day }} </td>
        </tr>
        <tr style="margin-bottom:30px">
            <td>وقت الحجز</td>
            <td>{{ $data->booking_time }} </td>
        </tr>
    <tr style="margin-bottom:30px">
        <td>المبلغ قبل الخصم</td>
        <td>{{ $data->sub_total }} </td>
    </tr>
    <tr style="margin-bottom:30px">
        <td>الخصم</td>
        <td>{{ $data->discount }} </td>
    </tr>
    <tr style="margin-bottom:30px">
        <td>المبلغ بعد الخصم</td>
        <td>{{ $data->total }} </td>
    </tr>
    <tr style="margin-bottom:30px">
        <td>الحالة</td>
        <td>{{ $data->status }} </td>
    </tr>
    <tr style="margin-bottom:30px">
        <td>وسيلة الدفع</td>
        <td>{{ $data->payment_way }} </td>
    </tr>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2">الاسم</td>
        <td colspan="2">{!! $data !!}</td>
    </tr>
    </tfoot>
</table>

</body>
</html>
