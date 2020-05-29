<style>
/* Jovana Jankovic 0586/17 -Funkcija za prikaz jela kod korisnika */

.box:hover {
  /*filter: blur(8px);*/
  opacity: 0.2;
  pointer-events: none;
  color:black;
  background-position: center;
  background-size: cover;
}

.box{
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
    font-size: 15px !important;
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
      /*background-image: url(prikazjela/jabuka.jpg);*/
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
          .about1 > h3 {
              font-size: 25px;
          }
          .about1 > p {
              font-weight: bold;
          }    
          .about1 .opis {
              font-size: 15px;
          }
          /*Amount je ono sa +/-*/
          .amount {
            text-align: right;
          }
        /*Price je poslednji red*/  
        .price {
          padding: 10px;
          font-weight: bold;
        }


        .dish_customer {
          position: relative;
          display: inline-block;
          padding: 5px;
        }
        
        .change > p {
            font-weight: bold;
            margin-top: 17px;
            margin-left: 12px;
        }
        .change > input {
            width: 25px;
            background: transparent;
            border: none;
            color: black;
            font-weight: bold;
            text-align: center;
        }

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

</style>