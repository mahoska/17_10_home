<template>
<div class="bookItem">
  <div class="row">
    <div  class="col-sm-12 col-md-12">
      <div class="err_info">{{err}}</div>
      <h1>{{book.name}}</h1>
      <div class="authors">{{book.authors}}</div>
    </div>
  </div>
  <div class="row">
    <div  class="col-sm-3 col-md-3">
          <img class='image_book style_border'  src='../assets/book.png'  alt='picture' >
    </div>
    <div  class="col-sm-9 col-md-9">
       <div class="ganres">{{book.ganres}}</div>
      <div class="price">
        <div v-if="if_discount" class="old-price">Old Price: <s>{{book.price}} GRN</s></div>
        <div><span v-if="if_discount">NEW</span> PRICE: <span class="new-price"> {{new_price}} GRN </span></div>
      </div>
    </div>
  </div>
  <div class="row">
    <div  class="col-sm-12 col-md-12 description">{{book.description}}</div>
  </div>
   <div class="row order" v-if="is_login">
    <div  class="col-sm-12 col-md-12">
      <p class="cart_info">{{isAddCart}}</p>
      <div class='row'>
        <div  class="col-sm-2 col-md-2">
          <input  type='text'  class='order_count form-control' @keydown="checkNumber" v-model="book_count"/>
        </div>
        <div  class="col-sm-10 col-md-10">
          <button class='btn' @click='add_cart(book.id)' >Add to Cart</button>
        </div>
      </div>
    </div>
  </div>
</div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'bookItem',
  props: ['bookId'],
  data () {
    return {
      book: {},
      if_discount: false,
      is_login: false,
      err: "",
      book_count: 1,
      isAddCart: "",
      add_cart_flag: false
    }
  },
  created(){
    var self = this
    axios.get('http://localhost:88/BOOK_SHOP/client/api/book/'+ this.bookId, this.config)
      //axios.get('http://192.168.0.15/~user15/BOOK_SHOP/client/api/cars/'+ book_id, this.config)
        .then(function (response) {
          self.book = response.data.data
          if(self.book.length == 0)
            self.err = "Information about this book is absent"
          //self.$nextTick(function () {
            //console.log(self.book)
          //})
        })
        .catch(function (error) {
          //console.log(error);
      });

      if(localStorage['hash_log'] && localStorage['user']){
          axios.get('http://localhost:88/BOOK_SHOP/client/api/auth/'+localStorage['hash_log']+"/"+localStorage['user'], this.config)
          //axios.get('http://192.168.0.15/~user15/BOOK_SHOP/client/api/auth/'+localStorage['hash_log']+"/"+localStorage['user'], this.config)
              .then(function (response) {
                if(parseInt(response.data.data)>0){
                  self.is_login = true
                } 
              });
      }

      
  },
  computed:{
    new_price: function(){
      if(parseInt(this.book.discount) > 0 ){
        this.if_discount = true
        return this.book.price - this.book.price * parseInt(this.book.discount) / 100
      }
      else{
        this.if_discount = false
        return this.book.price
      }
    }

  },
  methods:{
    checkNumber: function(event){
      // Allow: backspace, delete
      if (event.keyCode == 46 || event.keyCode == 8 ||
        // Allow: home, end, left, right
        (event.keyCode >= 35 && event.keyCode <= 39)) {
          //nothing to do
          return;
        }else{
          // Make sure it's a digit, and stop the keypress event
          if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
            event.preventDefault();
          }
        }
    },

    add_cart(book_id){
      /*
      var cart = [];							
      if (localStorage['cart']) {
        cart = JSON.parse(localStorage['cart']);
      }
      var cart_item = {'hash_log': localStorage['hash_log'],  'book_id': book_id, 'book_count': this.book_count}
      cart.push(cart_item);
      localStorage['cart'] = JSON.stringify(cart);
      */
      
      var self = this
        axios.get('http://localhost:88/BOOK_SHOP/client/api/auth/'+localStorage['hash_log']+"/"+localStorage['user'], this.config)
        //axios.get('http://192.168.0.15/~user15/BOOK_SHOP/client/api/auth/'+localStorage['hash_log']+"/"+localStorage['user'], this.config)
          .then(function (response) {
            var client_id = parseInt(response.data.data)
            if(client_id>0){
            var data = new FormData()
            data.append("book_id", book_id)
            data.append("client_id",client_id)
            data.append("count",self.book_count)
          
            axios.post('http://localhost:88/BOOK_SHOP/client/api/cart/', data, self.config)         
            //axios.post('http://192.168.0.15/~user15/BOOK_SHOP/client/api/cart/', data, this.config)
            .then(function (response) {
              console.log(response.data.data)
              if(response.data.data == 1) {
                self.isAddCart = "Book added to cart"
                
               
                self.add_cart_flag = true
                alert(self.add_cart_flag)
                setTimeout(function () {
                  self.isAddCart = ""
                },1500);   
              }     
          })
          .catch(function (error) {
            self.isAddCart = "Something wrong, the book was not added to the basket. Try later"
            setTimeout(function () {
                  self.isAddCart = ""
                },1500);  
                return;   
          });
        }else{
          self.isAddCart = "for the purchase you must register"
          setTimeout(function () {
                self.isAddCart = ""
              },1500);    
              return; 
        }
        })
        .catch(function (error) {
          // console.log(error);
          self.isAddCart = "for ordering you need to register"
          setTimeout(function () {
                self.isAddCart = ""
          },1500); 
          return;   
        });
alert(this.add_cart_flag)
        if(this.add_cart_flag == true){
          this.$emit('changeCountTotal', this.book_count )
          this.book_count = 1
          this.add_cart_flag = false
        }
    }
  }

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.bookItem{
  margin-top: 50px;
  text-align: left;
}

.authors{
  font-weight: bold;
  font-size: 17px;
  margin-left: 20px;
}

.ganres{
  font-style: italic;
}

.price{
   color: red;
   font-weight: bold;
   margin-top: 40px;
}

.old-price{
  margin-bottom: 20px;
}

.new-price{
  font-size: 17px;
}

.description{
  font-size: 15px;
}

.err_info, .cart_info{
  color: white;
  margin-top: 50px;
  font-weight: bold;
  font-size: 17px;
}

.order_count{
  max-width: 100px;
}

.order{
  margin-top:50px;
}

.order button{
  background-color: #2C3E50;
  color: white;
}


</style>
