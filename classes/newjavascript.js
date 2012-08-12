function(newDoc,oldDoc,userCtx){

  var type = (newDoc||oldDoc)['type'];
  
  if(type=="post"){
    if(newDoc.user){
      if(newDoc.user!=userCtx.name){
        throw({
          "forbidden":"You may only update this document with user "+userCtx.name
          });
      }
    }
  }
}