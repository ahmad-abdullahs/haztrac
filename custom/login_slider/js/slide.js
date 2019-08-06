   
       var indexer = 0;
       var animateInterval;

     function animate(){
        if(indexer == 0){
            $("#background-slideshow > #watch-image").fadeOut(1000);
            $("#background-slideshow > #home-image").fadeIn(1000);
        }
        else if(indexer == 1){
            $("#background-slideshow > #home-image").fadeOut(1000);
            $("#background-slideshow > #shop-image").fadeIn(1000);
        }
        else if(indexer == 2){
            $("#background-slideshow > #shop-image").fadeOut(1000);
            $("#background-slideshow > #dine-image").fadeIn(1000);
        }
        

        if(indexer == 2) indexer = 0;
        else indexer++;
    }

    animateInterval = setInterval(animate, 2000);
    animate();
       $(document).ready(
 
  function () {
   
    $('.nav li').hover(
      function () { 
        $('ul', this).fadeIn();
      },
      function () { 
        $('ul', this).fadeOut();
      }
    );
  }
);