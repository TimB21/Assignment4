# Assignment4 


// First section with text boxes 
{ "name" : {"$regex" : "room"} }  

{ "description" : {"$regex" : "room"} }   

{ "address.street" : {"$regex" : "Brooklyn"} } 

{ "address.suburb" : {"$regex" : "Manhattan"} }

{ "transit" : {"$regex" : "bus"} }

{ "property_type" : {"$regex" : "apartment"} }

{ "name" : {"$regex" : "room"}, "description" : {"$regex" : "room"} }  


// Second section with text boxes 
{ "acomodates" : { u1 : { $gt :  1, $lt : 8} } }    

{"$expr":{"$gt":[ "$accommodates" , 1] }  

// Third section with radio boxes 
{ "address.country" : "United States" }  

{ "room_type" : "Entire home/apt" }    

{ "bed_type" : "Futon" } 

{ "cancellation_policy" : "strict_14_with_grace_period" } 

{ "cancellation_policy" : "strict_14_with_grace_period",  "bed_type" : "Futon"} 

// Figure out how to match amenities field with multiple amenities
{ "amenities" : "Air conditioning"}
