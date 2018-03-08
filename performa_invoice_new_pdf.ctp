<?php 
/* require_once(ROOT . DS  .'vendor' . DS  . 'dompdf' . DS . 'autoload.inc.php');
use Dompdf\Dompdf;
use Dompdf\Options;
use Cake\Mailer\Email;
$options = new Options();
$options->set('defaultFont', 'Lato-Hairline');
$dompdf = new Dompdf($options);
$dompdf = new Dompdf();
 */

$html='<html>
<head>
<style>
@page { margin: 15px 15px 10px 30px; }

body{
line-height: 20px;
}
#header { position:fixed; left: 0px; top: -150px; right: 0px; height: 150px;}
#content{
position: relative;
}
@font-face {
font-family: Lato;
src: url("https://fonts.googleapis.com/css?family=Lato");
}
p{
margin:0;font-family: Lato;font-weight: 100;line-height: 1;
}
table td{
margin:0;font-family: Lato;font-weight: 100;padding:0;line-height: 1;
}
table.table_rows tr.odd{
page-break-inside: avoid;
}
.table_rows, .table_rows th, .table_rows td {
border: 1px solid #000;border-collapse: collapse;padding:2px;
}
.itemrow tbody td{
border-bottom: none;border-top: none;
}
.table2 td{
border: 0px solid #000;font-size: 14px;padding:0px;
}
.table3 {
margin-top:-5px; border-top: none;
}
.table-amnt td{
border: 0px solid #000;padding:0px;
}
.table_rows th{
font-size:14px;
}
.avoid_break{
page-break-inside: avoid;
}
tr.noBorder > td {
border:0;
}
tr.Borderbottom > td {
border-bottom:0;
}

.text_align{
text-align:center;	
}
</style>
<body><center><strong>INVOICE</strong></center><br/>';
 foreach($master_member as $member_data)
{ 
if(date('m',strtotime($member_data->date)) < 4){
		$from_year=(date('y',strtotime($member_data->date))-1);
		$f_from_year=(date('Y',strtotime($member_data->date))-1);
		$to_year=date('y',strtotime($member_data->date));
	}else{
		$from_year=date('y',strtotime($member_data->date));
		$f_from_year=(date('Y',strtotime($member_data->date)));
		$to_year=(date('y',strtotime($member_data->date))+1);
	}
			foreach($MasterCompanies as $MasterCompany) 
				{
					$html1=$MasterCompany->company_information;
					$st_reg_no=$MasterCompany->st_reg_no;
					$pan_no=$MasterCompany->pan_no;
					$gst_number=$MasterCompany->gst_number;
					$compare_date=date("Y-m-d",strtotime($member_data->date)); 
					$compare_date=strtotime($compare_date);
					$gst_date=strtotime("2017-07-01");
					if($gst_date<$compare_date){
						$text_type="GSTIN/UIN";
						$type_number=$gst_number;
					}else{
						
						$text_type="ST Reg No.";
						$type_number=$st_reg_no;
					}
					
				}

$html.='<div id="content">

<table width="100%" class="table_rows table3">
	<tr>
		<td align="" rowspan="2" colspan="2">

		<h3>'.$member_data->user->company_organisation.' </h3>
		'.$member_data->user->address.'<br/>
		'.$member_data->user->city.'';
		if(!empty($member_data->user->pincode))
							{
								$html.=' - '.$member_data->user->pincode;
							} 
		$html.='
		<br/> Ph. No. '.$member_data->user->office_telephone.'<br/>
		Email '.$member_data->user->email.' <br/>';
		if($member_data->user->member_type_id==1)
							{
								$html.='Authorized Representative '.$member_data->user->member_name.'';
							}
		$html.='</td>
		
		<td  colspan="2">
			Invoice No. <br/> UCCI/I'.$performa_invoice_no=sprintf("%04d", $member_data->performa_invoice_no).'/'.$from_year.'-'.$to_year.'

		</td>
		<td  colspan="2">
			Dated <br/> '.date('d-m-Y', strtotime($member_data->date)).'

		</td>
	</tr>
	<tr>
		<td  colspan="2">
			Suppliers Ref.
		
		</td>
		<td  colspan="2">
			Other Reference(s)
		
		</td>
	</tr>

	<tr>
	<td align=""  colspan="2">

	'.$html1.'
	'.$text_type.' '.$type_number.'<br/>
	 PAN No. '.$pan_no.'
	</td>
	<td colspan="4">
	</td>
		
	
	</tr>
	<tr>
		 
					<th class="text_align">Sr no.</th>
					<th class="text_align">Particulars</th>
					<th class="text_align">Quantity</th>
					<th class="text_align">Rate</th>
					<th class="text_align">Per</th>
					<th class="text_align">Amount</th>
				</tr>';
				if(!empty($member_data->user->turn_over_id))
				{ $sr_no=0;						
					foreach($master_turn_over as $turn_over_data)
					{
						$sr_no++;
						$html.='<tr>
								<td>'.$sr_no.'</td>
								<td style=" "> <strong>Annual Subscription for F.Y. '.$f_from_year.'-'.$to_year.' </strong></td>
								<td></td>
								<td></td>
								<td></td>
								<td style="text-align:right; "><strong>'.$fee=number_format($turn_over_data->subscription_amount, 2, '.', '').'</strong></td>
							</tr>';


					}
				}
				
					foreach($master_membership_fee as $membership_data)
					{
					$sr_no++;
					$html.='<tr>
						<td  style=" ">'.$sr_no.'</td>
						<td  style=" "><strong>'.$membership_data->component.'</strong></td>
						<td></td>
						<td></td>
						<td></td>
						<td  style="text-align:right; font-size:15px;"><strong>'.$fee=number_format($membership_data->subscription_amount, 2, '.', '').' </strong></td>
					</tr>';

					}
				$sr_no++;
				$html.='
				<tr>
					<td >'.$sr_no.'</td>
					<td style="" width="40%"><strong>Basic Amount </strong></td>
					<td></td>
						<td></td>
						<td></td>
					<td style="text-align:right; font-size:15px;"><strong>
					'.number_format($member_data->sub_total, 2, '.', '').'</strong>
					</td>
				</tr>';
				
				foreach($member_data->member_fee_tax_amounts as $tax_data)
				{
					$sr_no++;

				$html.='<tr class="tax_cal">
				<td>'.$sr_no.'</td>
				<td ><strong>'.$tax_data->master_taxation->tax_name.' @ '.$tax_data->tax_percentage.'% </strong></td>
					<td></td>
					<td></td>
					<td></td>
				
				<td style="text-align:right; font-size:15px;"><strong>'.number_format($tax_data->amount, 2, '.', '').'</strong>
				</td>
				</tr>';
				}
				
				$html.='
				<tr>
					
					<td align="right" colspan="2"><strong> Total </strong></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="text-align:right; font-size:15px;"><strong> Rs. '.number_format($member_data->grand_total, 2, '.', '').'</strong></td>
				</tr>';
				
			$html.='
				<tr>
					
					<td colspan="5"> <span style="float:left;">Amount Chargeable(in words) </span> <br/>
					<strong>INR '.ucwords($this->requestAction(['controller'=>'Users', 'action'=>'convert_number_to_words'],['pass'=>array($member_data->grand_total)])).' Only.</strong>
					<br/> <br/> <br/>
						
					</td>
					<td align="right" valign="top">
					<span style="float:right;">E & O.E</span>
					</td>
				</tr> 
				
				<tr>
					
					<td colspan="2"> 
					<span> Companys GSTIN/UIN : <strong> '.$member_data->user->gst_number.' </strong> <span>
					</td>
					<td colspan="4" align="right"> 
					<strong style="font-size:15px;">For: Udaipur Chamber of Commerce & Industry </strong>
					<br/> <br/> <br/> <br/>
					<p style="width:100%; text-align:right; font-size: 15px;padding-right:8px;">
						Authorised Signatory</p>
					</td>
					
				</tr> 
				

</table>

</div>
</body>
</html>';
}
echo $html;
/* 	
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($name,array('Attachment'=>0));
exit(0); */