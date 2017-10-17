<template>
  <div class="bookSection col-sm-3 col-md-3 clearfix">
    <div class="thumbnail book_tabl_el">
	   <img src="../assets/book.png" alt="" class="book-img" />
	   <div class="caption">
	        <h5 @click="showItemBook(book.id)" class="book_name">
            <!--router-link  :to="'/bookItem/'+book.id">{{ book.name }}</router-link-->
            {{ book.name }}
          </h5>
         <div  class="discount"><span v-if="book_discount">discount</span></div>
		     <div class="price"><strong>{{ price}} GRN</strong></div>
	   </div>
	  </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'bookSection',
  props: ['book'],
  data () {
    return {
      book_discount: false
    }
  },
  created(){
    if(parseInt(this.book.discount) > 0 ) {this.book_discount = true}
  },
  computed:{
    price: function(){
      if(parseInt(this.book.discount) > 0 )
        return this.book.price - this.book.price * parseInt(this.book.discount) / 100
      else
        return this.book.price
    }
  },
  methods:{
    showItemBook(book_id){
      this.$emit('showBook', book_id)
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.book_tabl_el{
	min-height: 250px;
	max-height: 250px;
}

.book_tabl_el img{
	height: 100px;
}



.discount{
  font-size: 12px;
  color: red;
  font-weight: bold;
  max-height: 45px;
  min-height: 45px;
  line-height: 45px;
 
  
}

.book_name{
  font-weight: bold;
  color:#0271BC;
  cursor: pointer;

}

</style>
