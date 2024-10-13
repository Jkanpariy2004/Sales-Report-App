<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Bill No:{{ $sale->bill_no }}</title>
    <link rel="icon" type="image/x-icon" href="/../../assets/img/favicon/favicon.ico" />
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            text-indent: 0;
        }

        table,
        tbody {
            vertical-align: top;
            overflow: visible;
        }
    </style>
</head>

<body>
    <table style="border-collapse:collapse; margin: auto; width: 95%; margin-top: 10px;" cellspacing="0">
        <tr style="height:69pt;">
            <td style="width:528pt; border-top-style:solid; border-top-width:1pt; border-left-style:solid; border-left-width:1pt; border-bottom-style:solid; border-bottom-width:1pt; border-right-style:solid; border-right-width:1pt; padding: 3px;"
                colspan="6">
                <div style="width: 100%; font-size: 18px;">
                    <div style="display: inline-block; width: 33.33%; text-align: left;">
                        Original
                    </div>
                    <div style="display: inline-block; width: 33.33%; text-align: center;">
                        Shree Sheetalnathay Namah
                    </div>
                    <div style="display: inline-block; width: 32%; text-align: right;">
                        TAX INVOICE
                    </div>
                </div>
                <div style="width: 100%; font-size: 18px;">
                    <div style="display: inline-block; width: 33.33%; text-align: left;">
                        Duplicate
                    </div>
                    <div style="display: inline-block; width: 33.33%; text-align: center; font-size: 23px; font-weight: 600;">
                        C. M. JARIWALA
                    </div>
                    <div style="display: inline-block; width: 32%; text-align: right;">
                        RETAIL INVOICE
                    </div>
                </div>
                <div style="text-align: center; font-size: 18px; font-weight: 600;">
                    <p>5/567-B, Haripura Main Road, Surat-395 003</p>
                    <p>Phone: 0261-2437144, 9328269030</p>
                </div>
            </td>
        </tr>
        <tr style="height:18pt">
            <td style="padding: 3px; width:528pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;"
                colspan="6">
                <div style="width: 100%; font-size: 16px;">
                    <div style="width: 50%; display: inline-block; font-weight: 600; text-align: left;">
                        GSTIN: 24ADLPJ8759K1ZW
                    </div>
                    <div style="width: 49%; display: inline-block; font-weight: 600; text-align: right;">
                        State Code: 24-GJ
                    </div>
                </div>
            </td>
        </tr>
        <tr style="height:45pt">
            <td style="padding: 3px; width:396pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
                colspan="3">
                <div style="font-size: 18px; width: 100%; border-bottom: 1px solid black;">
                    <p style="font-weight: 600;">M/S:{{ $sale->customer_name }}</p>
                </div>
                <p style="font-size: 17px;">Address:{{ $sale->place }}</p>
                <div style="width: 100%; font-size: 17px; margin-top: 10px;">
                    <div style="width: 50%; display: inline-block; text-align: left;">
                        <p><b>GSTIN:</b> {{ $sale->gst_no }}</p>
                    </div>
                    <div style="width: 49%; display: inline-block; text-align: right;">
                        <p><b>State Code:</b> {{ $sale->state_code }}</p>
                    </div>
                </div>
            </td>
            <td style="padding:3px; width:132pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
                colspan="3">
                <div>
                    <p>
                        <span style="font-size: 16px; font-weight: 600;">Invoive No.:</span>
                        <span>{{ $sale->bill_no }}</span>
                    </p>
                </div>
                <div>
                    <p>
                        <span style="font-size: 16px; font-weight: 600;">Invoive Date:</span>
                        <span>{{ $sale->bill_date }}</span>
                    </p>
                </div>
            </td>
        </tr>
        <tr style="height:23pt">
            <td style="width:528pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
                colspan="6">

            </td>
        </tr>
        <tr style="height:29pt">
            <td
                style="text-align: center; font-weight: 600; font-size: 17px; width:38pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;">
                <p>No.</p>
            </td>
            <td
                style="text-align: center; font-weight: 600; font-size: 17px; width:264pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;">
                <p>Description</p>
            </td>
            <td
                style="text-align: center; font-weight: 600; font-size: 17px; width:54pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;">
                <p>HSN Code</p>
            </td>
            <td
                style="text-align: center; font-weight: 600; font-size: 17px; width:53pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;">
                <p>Qty</p>
            </td>
            <td
                style="text-align: center; font-weight: 600; font-size: 17px; width:54pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;">
                <p>Rate</p>
            </td>
            <td
                style="text-align: center; font-weight: 600; font-size: 17px; width:65pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt;">
                <p>Amount</p>
            </td>
        </tr>
        <tr style="height:254pt">
            <td
                style="text-align: center; width:38pt; border-top-style:solid; border-top-width:1pt; border-left-style:solid; border-left-width:1pt; border-bottom-style:solid; border-bottom-width:1pt; border-right-style:solid; border-right-width:1pt">
                <div style="margin: 10px; font-size: 17px;">
                    @foreach ($sale->items as $index => $item)
                        {{ $index + 1 }}<br>
                    @endforeach
                </div>
            </td>
            <td
                style="text-align: center; width:264pt; border-top-style:solid; border-top-width:1pt; border-left-style:solid; border-left-width:1pt; border-bottom-style:solid; border-bottom-width:1pt; border-right-style:solid; border-right-width:1pt">
                <div style="margin: 10px; font-size: 17px;">
                    @foreach ($sale->items as $item)
                        {{ $item->product_name }}&nbsp;({{ $item->hsn_code }})<br>
                    @endforeach
                </div>
            </td>
            <td
                style="text-align: center; width:54pt; border-top-style:solid; border-top-width:1pt; border-left-style:solid; border-left-width:1pt; border-bottom-style:solid; border-bottom-width:1pt; border-right-style:solid; border-right-width:1pt">
                <div style="margin: 10px; font-size: 17px;">
                    @foreach ($sale->items as $item)
                        {{ $item->hsn_code }}<br>
                    @endforeach
                </div>
            </td>
            <td
                style="text-align: center; width:53pt; border-top-style:solid; border-top-width:1pt; border-left-style:solid; border-left-width:1pt; border-bottom-style:solid; border-bottom-width:1pt; border-right-style:solid; border-right-width:1pt">
                <div style="margin: 10px; font-size: 17px; white-space: nowrap;">
                    @foreach ($sale->items as $item)
                        {{ $item->unit }}-{{ $item->quantity }}<br>
                    @endforeach
                </div>
            </td>
            <td
                style="text-align: center; width:54pt; border-top-style:solid; border-top-width:1pt; border-left-style:solid; border-left-width:1pt; border-bottom-style:solid; border-bottom-width:1pt; border-right-style:solid; border-right-width:1pt">
                <div style="margin: 10px; font-size: 17px;">
                    @foreach ($sale->items as $item)
                        {{ $item->price }}<br>
                    @endforeach
                </div>
            </td>
            <td
                style="text-align: center; width:65pt; border-top-style:solid; border-top-width:1pt; border-left-style:solid; border-left-width:1pt; border-bottom-style:solid; border-bottom-width:1pt; border-right-style:solid; border-right-width:1pt">
                <div style="margin: 10px; font-size: 17px;">
                    @foreach ($sale->items as $item)
                        {{ $item->quantity * $item->price }}<br>
                    @endforeach
                </div>
            </td>
        </tr>

        <tr style="height:16pt">
            <td style="padding: 3px; font-size: 16px; width:291pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
                colspan="2" rowspan="4">
                <p><b>Trasport:-&nbsp;&nbsp;</b>{{ $sale->transport_no }}</p>
                <p><b>GST TIN Transport No.:-&nbsp;&nbsp;</b>{{ $sale->transport_gst_tin_no }}</p>
                <p><b>Parcel:-&nbsp;&nbsp;</b>{{ $sale->parcel }}</p>
            </td>
            <td style="text-align: right; padding: 3px; width:237pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
                colspan="4">
                <?php $totalAmount = 0; ?>
                @foreach ($sale->items as $item)
                    <?php $totalAmount += $item->quantity * $item->price; ?>
                @endforeach
                <div style="width: 100%; font-size: 18px;">
                    <div style="width: 49%; display: inline-block;">
                        <p>Gross Amount:</p>
                    </div>
                    <div style="width: 49%; display: inline-block;">
                        {{ $totalAmount }}
                    </div>
                </div>
            </td>
        </tr>
        <tr style="height:18pt">
            <td style="text-align: right; padding: 3px; width:237pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
                colspan="4">
                <div style="width: 100%; font-size: 18px;">
                    @if ($item->tax_type == 'CGST/SGST')
                        <div style="width: 49%; display: inline-block;">
                            <p>({{ $taxAmount = $item->tax / 2 }}%)SGST:</p>
                        </div>
                        <div style="width: 49%; display: inline-block;">
                            {{ $totalsgst = ($totalAmount * $taxAmount) / 100 }}
                        </div>
                    @elseif ($item->tax_type == 'IGST')
                        <div style="width: 49%; display: inline-block;">
                            <p>({{ $taxAmount = $item->tax }}%)IGST:</p>
                        </div>
                        <div style="width:49%; display: inline-block;">
                            {{ $totaligst = ($totalAmount * $taxAmount) / 100 }}
                        </div>
                    @endif
                </div>
            </td>
        </tr>
        <tr style="height:18pt">
            <td style="text-align: right; padding: 3px; width:237pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
                colspan="4">
                <div style="width: 100%; font-size: 18px;">
                    @if ($item->tax_type == 'CGST/SGST')
                        <div style="width: 49%; display: inline-block;">
                            <p>({{ $taxAmount = $item->tax / 2 }}%)CGST:</p>
                        </div>
                        <div style="width: 49%; display: inline-block;">
                            {{ $totalcgst = ($totalAmount * $taxAmount) / 100 }}
                        </div>
                    @endif
                </div>
            </td>
        </tr>
        <tr style="height:25pt">
            <td style="text-align: right; padding: 3px; width:237pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
                colspan="4">
                <div style="width: 100%; font-size: 18px;">
                    <div style="width: 49%; display: inline-block;">
                        <p style="font-weight: 600;">Net Amount:</p>
                    </div>
                    <div style="width: 49%; display: inline-block;">
                        @if ($item->tax_type == 'CGST/SGST')
                            <b>{{ $NetAmount = $totalAmount + $totalsgst + $totalcgst }}</b>
                        @elseif ($item->tax_type == 'IGST')
                            <b>{{ $NetAmount = $totalAmount + $totaligst }}</b>
                        @endif
                    </div>
                </div>
            </td>
        </tr>
        <tr style="height:20pt">
            <td style="padding: 3px; font-size: 16px; width:528pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
                colspan="6">
                <p><b>Rupes in Word:</b> {{ convertNumberToWords($NetAmount) }}</p>
            </td>
        </tr>
        <tr style="height:56pt">
            <td style="padding: 3px; font-size: 15px; width:528pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
                colspan="6">
                <p><b>Bank Name:</b> Union Bank of India - Rampura Branch, Surat.</p>
                <p><b>Bank A/C:</b> 348701010036041</p>
                <p><b>IFSC Code:</b> UBIN0544272</p>
            </td>
        </tr>
        <tr style="height:90pt;">
            <td style="padding:3px; 528pt;border-top-style:solid;border-top-width:1pt;border-left-style:solid;border-left-width:1pt;border-bottom-style:solid;border-bottom-width:1pt;border-right-style:solid;border-right-width:1pt"
                colspan="6">
                <div style="width:100%;">
                    <div style="width: 33%; display: inline-block; margin-top: 0px !important;">
                        <h4>Terms & Conditions :</h4>
                        <ul style="margin-left: 30px; margin-top: 5px; font-size: 15px;">
                            <li>Interest at 24% p.a. will be charged for late payments.</li>
                            <li>We check and pack the goods carefully before dispatch.</li>
                            <li>Cheque Return charge 150 RS. Compulsory.</li>
                            <li>All Disputes are subject to SURAT jurisdiction only</li>
                        </ul>
                    </div>
                    <div style="width: 33%; text-align: center; display: inline-block;">
                        <div>
                            <h4>Receiver Sign</h4><br><br><br><br><br><br><br>
                        </div>
                        <div>
                            <div style="border-bottom: 3px solid black; width: 60%; margin: auto;"></div>
                        </div>
                    </div>
                    <div style="width: 32.5%; text-align: right; display: inline-block;">
                        <h4>FOR, C. M. JARIWALA</h4><br><br><br><br><br><br>
                        <h4>Proprietor / Authorised Signature</h4>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
