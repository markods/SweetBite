/**Jovana Jankovic 0586/17 -Funkcija za prikaz jela kod korisnika*/ 

<style>
.box:hover {
  background: url(prikazjela/jabuka.jpg);
  filter: blur(4px);
  pointer-events: none;
  color:black;
  background-position: center;
  background-size: cover;
}

.box{
  background: url(prikazjela/jabuka.jpg);
  background-position: center;
  background-size: cover;
  width:360px;
  height:300px;
  color: black;
  font: 1.5vw Arial;
}
.ar-image {
  position: relative;
  height: 300px;
  width: 340px;
}
  .article-image {
    height: 300px;
    width: 340px;
    color: black !important;
    font-size: 17px !important;
    font-weight: bold;
  }

 .article-image p {
    font-size:15px;
    line-height: 1.7em;
    color: black;
  }
    .article-image:before {
      content: '';
      position: absolute;
      height: 100%;
      width: 100%;
      top: 0;
      left: 0;
      background-position: center !important;
      background-size: cover !important;
      background-image: url(prikazjela/jabuka.jpg);
    }

    .article-image:hover:before {
      filter:  blur(5px) !important;
    }
      /*Dovoljno je ovo uraditi samo
       *za div jer su svi ostali tipovi
       *elemenata okruzeni divovima*/
      .article-image > div {
        opacity: 0;
      }  
      .article-image:hover > div {
        opacity: 1;
        /*samo postaje vidljivo,
         *svi ostali vidovi sredjivanja
         *se rade bez:hover*/
      }
        /*Base je prvi red*/
        .base {     
          display: flex;
          padding: 10px;
          margin: 0px;
          height: 260px;
        }
          /*About je prvih 10 kolona*/
          .about1 {
            padding: 0px;
          }
          /*Amount je ono sa +/-*/
          .amount {
            text-align: right;
          }
        /*Price je poslednji red*/  
        .price {
          padding: 10px;
        }


        .dish_customer {
          position: relative;
          display: inline-block;
          padding: 5px;
        }
/*
.cont1 {
  text-align: left;
  color: white;
  width: 1000px;
}*/

.dish_temp {
  width: 280px;
  position: relative;
  display: inline-grid;
  padding: 5px;
  /*text-align: left;*/
  margin-right: 92px;
  
}


.dish > elem{
  width: 280px;
  position: relative;
  display: inline-grid;
  padding: 5px;
  /*text-align: left;*/
  margin-right: 92px;
  visibility: none;
  
}

.elem {
  opacity: 0;
}

.elem:hover {
  opacity: 1;
}

#content {
  flex: 1 0 auto;
  margin-top: 5rem;
}

</style>