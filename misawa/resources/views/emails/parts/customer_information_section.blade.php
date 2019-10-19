
<table>
    <tbody>
    <tr>
        <td align="right">Name:</td>
        <td style="padding-left: 15px;">{{$po->customer->sex}} {{$po->customer->name}}</td>
    </tr>
    <tr>
        <td align="right">Address:</td>
        <td style="padding-left: 15px;">
            〒{{$po->customer->postcode}} <br>
            {{$po->customer->address1}} <br>
            {{$po->customer->address2}}
        </td>
    </tr>
    <tr>
        <td align="right">Email:</td>
        <td style="padding-left: 15px;">{{$po->customer->email}} </td>
    </tr>
    <tr>
        <td align="right">Phone:</td>
        <td style="padding-left: 15px;">{{$po->customer->phone}} </td>
    </tr>
    </tbody>
</table>