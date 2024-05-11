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
@php
    $total=0;
@endphp
<table class="dt-multilingual table table-bordered" border=1>
    <thead>
    <tr>
        <th>#</th>
        <th>اسم العميل</th>
    </tr>
    </thead>
    <tbody>
        <tr style="margin-bottom:30px">
            <td>{!! $data !!} </td>
            <td>{!! $data !!} </td>
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
