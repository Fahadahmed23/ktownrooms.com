<div class="contact-hotel-sec p-2">
  
    <ul id="mediaList" class="media-list">
        <div class="row m-0">
            <li class="media m-0 col-md-2" ng-repeat="c in hotel_contacts track by $index">
                <div class="media-body bg-light border p-2 rounded">
                    <div class="media-title font-weight-semibold">[[c.ContactPerson]]
                        
                    <span class="align-self-center ml-3 float-right">
                        <span class="list-icons list-icons-extended">
                            <a href="" class="list-icons-item" ng-click="editContact(c)" title="Edit Address"><i class="icon-pencil6"></i></a>
                            <a href="" class="list-icons-item" data-popup="tooltip" title="" ng-click="deleteContact(c)" data-trigger="hover" data-original-title="Remove"><i class="icon-cross2"></i></a>
                        </span>
                    </span>
                    </div>
                    <span class="text-muted"> 
                        <p class="my-0"><i ng-class="getTypeClass(c.contact_type.ContactType)" class="mr-2"></i>: [[c.Value]] </p>
                    </span>
                </div>
                <li class="mx-2"><button ng-click="addContact()" class="btn btn-info"><i class="icon-phone-plus2 mr-1"></i></button></li>
                <li><button ng-if="hotel_contacts.length>0" type="button" ng-click="saveContact()" id="btn-save" class="btn btn-sm bg-success"><i class="icon-floppy-disk mr-1"></i></button></li>
            </li>
        </div>
    </ul>
</div>