$(document).ready(function(){
    if (
         $("h1").hasClass("midiArea") || 
         $("section").hasClass("midiArea") || 
         $("ul").hasClass("midiArea")){                    
      $("section.main").addClass("halfWeight");
    }
});