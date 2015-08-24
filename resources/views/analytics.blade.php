<div>
    <h1>Account Name : {{$data->profileInfo->webPropertyId}}</h1>
    <div>
        <table border="thin" cellpadding="7" cellspacing="1" style="text-align: center;">
            <tr style="font-weight: bold;">
                <td>Assisted Conversions</td>
                <td>Assisted Value</td>
                <td>First Interaction Conversions</td>
                <td>First Interaction Value</td>
                <td>Last Interaction Conversions</td>
                <td>Last Interaction Value</td>
            </tr>
            <tr>
                <td>{{$data->totalsForAllResults['mcf:assistedConversions']}}</td>
                <td>{{$data->totalsForAllResults['mcf:assistedValue']}}</td>
                <td>{{$data->totalsForAllResults['mcf:firstInteractionConversions']}}</td>
                <td>{{$data->totalsForAllResults['mcf:firstInteractionValue']}}</td>
                <td>{{$data->totalsForAllResults['mcf:lastInteractionConversions']}}</td>
                <td>{{$data->totalsForAllResults['mcf:lastInteractionValue']}}</td>
            </tr>
        </table>
    </div>