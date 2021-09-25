<?php $counter =0; $row_no = 0; $NoOfRooms = \Session::get("SelectedRoom");  \Session::forget('SelectedRoom');?>
                           
@foreach($detailsChild as $detailChild)
<tr>
    <td>
        <h3>{{$detailChild->room_type_name}}</h3>
        <span class="badge badge-success">{{$detailChild->room_type_description}} </span>
        <input type="hidden" name="roomTypeName[]" value ="{{$detailChild->room_type_name}}" >
        <input type="hidden" name="PartnerPrice[]" value ="{{$detailChild->PartnerPrice}}" >
        <input type="hidden" name="SellingPrice[]" value ="{{$detailChild->SellingPrice}}" >
        <input type="hidden" name="HotelID[]" value ="{{$detailChild->HotelID}}" >
        <input type="hidden" name="HotelName[]" value ="{{$detailChild->HotelName}}" >
        <input type="hidden" name="room_type_name[]" value ="{{$detailChild->room_type_name}}" >
        <p>{{$detailChild->beds_information}} 
            <img src="{{url('public/uploads/website/beds/' . $detailChild->beds_image)}}" style="width: 24px;"> 

            <!-- <i class="icon-bed2"></i> <i class="icon-bed2"></i> -->
        </p>
        <div class="col-12 mr-0">
            <div class="row">
                @foreach($Services as $service)
                    <div class="col-md-6 my-1 px-0 r-facilities">
                        <img src="{{url('public/uploads/website/services/' . $service->Icon)}}" style="width: 24px;"> 
                            {{$service->ServiceName}}
                    </div>
                @endforeach
                </div>
        </div>
    </td>
    <td>
<div class="txtcol">

<p >Check-in: <span class="mChkin"></span> </p>
<p >Check-out: <span class="mChkOut"></span></p>

</div>
    </td>
    <td>
        <span class="d-flex">

            @for($i = 0; $i < $detailChild->adults_sleep; $i++)
            <i class="icon-user" style="font-size:16px;"> </i> 
            @endfor
            <small class="mr-1 ml-1">+</small>
            @for($i = 0; $i < $detailChild->children_sleep; $i++)
            <i class="icon-user" style="font-size:12px;"> </i> 
            @endfor
        </span>
    </td>
    <td>
        <div class="qty d-flex">
            <span id="minus<?php echo $row_no; ?>" class="minusadult bg-dark">-</span>
            <input id="ddOccupants<?php echo $row_no; ?>" type="text" readonly="" class="countadult plusmiusbtns ddOccupants" name="occupants[]" class="" data-capacity="<?php echo $detailChild->Capacity; ?>" data-maxallowed="<?php echo $detailChild->MaxAllowed; ?>" data-additionalcharges="<?php echo $detailChild->AdditionalGuestCharges; ?>" style="width:100%" id="occu_<?php echo $row_no; ?>" type="number" min="0" max="<?php echo $detailChild->MaxAllowed; ?>" value="<?php echo $detailChild->Capacity; ?>" />
            <!-- <input type="text" class="countadult plusmiusbtns" name="adults" value="2" min="1" readonly=""> -->
            <span id="plus<?php echo $row_no;?>" class="plusadult bg-dark">+</span>
        </div>
        <!--<input name="occupants[]" class="ddOccupants" data-capacity="<?php echo $detailChild->Capacity; ?>" data-maxallowed="<?php echo $detailChild->MaxAllowed; ?>" data-additionalcharges="<?php echo $detailChild->AdditionalGuestCharges; ?>" style="width:100%" id="occu_<?php echo $row_no; ?>" type="number" min="0" max="<?php echo $detailChild->MaxAllowed; ?>" value="<?php echo $detailChild->Capacity; ?>" />-->
    </td>
    <td>
        <h3>PKR  <span class="spnPrice">{{number_format($detailChild->SellingPrice * $nights, 0)}}</span></h3>
        <input type="hidden" class="hdnPrice" value = "{{number_format($detailChild->SellingPrice * $nights, 0)}}">
        <p><strong>Included: </strong>Breakfast</p>
        <!-- <p><strong>Excluded: </strong>13 % Tax</p> -->
    </td>
    <td>
        <p><img src="{{ url('resources/assets/web') }}/img/breakfast.png" style="width: 24px;"> <strong>Good Breakfast</strong> Included</p>
        <p><i class="icon-checkmark4"></i> <strong>Total cost to cancel</strong></p>
        <p><i class="icon-checkmark4"></i> <strong>NO PREPAYMENT NEEDED </strong>– pay at the property</p>
    </td>
    <td>
        
        <!-- <span class="badge badge-secondary" style="font-size:14px">
        {{ Session::has('rooms') ? Session::get('rooms') :$mRooms }}
        </span> -->
        
        <select class="form-group NoOfRooms form-control" name="NoOfRooms[]">
        <option value="0">Select</option>
        <option value="1" <?php if(!empty($NoOfRooms)) if("1" == $NoOfRooms[$row_no]) echo "selected"; ?>>1 PKR {{number_format($detailChild->SellingPrice * $nights*1, 0)}}</option>
        <option value="2" <?php if(!empty($NoOfRooms)) if("2" == $NoOfRooms[$row_no]) echo "selected"; ?>>2 PKR {{number_format($detailChild->SellingPrice * $nights*2, 0)}}</option>
        <option value="3" <?php if(!empty($NoOfRooms)) if("3" == $NoOfRooms[$row_no]) echo "selected"; ?>>3 PKR {{number_format($detailChild->SellingPrice * $nights*3, 0)}}</option>
        <option value="4" <?php if(!empty($NoOfRooms)) if("4" == $NoOfRooms[$row_no]) echo "selected"; ?>>4 PKR {{number_format($detailChild->SellingPrice * $nights*4, 0)}}</option>
        <option value="5" <?php if(!empty($NoOfRooms)) if("5" == $NoOfRooms[$row_no]) echo "selected"; ?>>5 PKR {{number_format($detailChild->SellingPrice * $nights*5, 0)}}</option>
        </select>
    
        <input type="hidden" name="costOfRoom[]" value ="{{$detailChild->SellingPrice * $nights}}" >
    </td>
    <td>
        
        <?php if($counter == 0) { 
        echo '
        
        
        <ul class="pl-3">
            <li><b><h1 id="h1noOfRoom"> </h1></b> rooms for </li>
            <li><h1><b><span id="spnPrice"> </span></b></h1></li>                                        
            <li>Confirmation is immediate</li>
            <li>No registration required</li>
            <li>No booking or credit card fees!</li>
        </ul>
        <button type="submit" class="btn-org d-inline">Book now</button>
        ';


        }
        ?>
    </td>
</tr>

<?php $counter++; $row_no++; ?>
@endforeach