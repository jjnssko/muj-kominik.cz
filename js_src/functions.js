function navScroll(){
  // Přidání scrollovací funkce do všech odkazů
  $("a").on('click', function(event) {

    // Ujištění se zda this.hash má hodnotu před přepsání výchozího chování
    if (this.hash !== "") {
      // Předejde ukotvení po kliknutí
      event.preventDefault();

      // Uložení hashe
      var hash = this.hash;

      // Využití jQuery animate() metody pro přidání scrollování po stránce
      // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 1000, function(){

        // Přidání hashe (#) do URL když se dokončí scrollování (výchozí klikací chování)
        window.location.hash = hash;
      });
    } // Ukončení IFu
  });
}
$(document).ready(navScroll());



function vyberKategorie(str) {
  var ddl = document.getElementById("kategorie");
  var selectedValue = ddl.options[ddl.selectedIndex].value;
  if (selectedValue == "default") {
    alert("Prosím, vyberte kategorii");
  } else {
    if (str=="") {
      document.getElementById("nazevClanku").innerHTML="";
      return;
    }
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
      if (this.readyState==4 && this.status==200) {
        document.getElementById("nazevClanku").innerHTML=this.responseText;
      }
    }
    xmlhttp.open("POST","smazatClanek.php?kategorie="+str,true);
    xmlhttp.send();
  }
}
