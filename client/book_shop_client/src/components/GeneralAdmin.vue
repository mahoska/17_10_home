<template>
  <div class="general container">
    <div class="row">
      <div class="col-sm-6 col-md-4">
        <button class="btn  btn-info" @click="addFormOpenAuthor">new Author</button>

        <div class="form-group">
          <label>Edit or Delete</label>
          <select v-model="author" class="form-control"  @change="changeSelectAuthor()">
            <option value="">select author</option>
            <option v-for="author in authors" :value="author.id">
                  {{author.surname}} {{author.name}}
            </option>
          </select>
        </div>

      <!--ganere-->
        <button class="btn  btn-info" @click="addFormOpenGanre">new Ganre</button>

        <div class="form-group">
          <label>Edit or Delete</label>
          <select v-model="ganre" class="form-control"  @change="changeSelectGanre()">
            <option value="">select ganre</option>
            <option v-for="ganre in ganres" :value="ganre.id">
              {{ganre.name}}
            </option>
          </select>
        </div>
      </div>
      <!--endganre-->

      <div class="col-sm-6 col-md-8">
        <div v-if="is_author" class="add">
          <div class="lbl_add">Author add form</div>
          <p class="bg-danger" id="err" style="width: 100%">{{err_author}}</p>
          <div class="form-group">
            <label for="inputName">Name</label>
            <input type="text" class="form-control" id="inputName" placeholder="Enter name" v-model="name">
          </div>
          <div class="form-group">
            <label for="inputSname">Surname</label>
            <input type="text" class="form-control" id="inputSname" placeholder="Enter surname" v-model="surname">
          </div>
          <button  class="btn btn-primary">Add author</button>
        </div>

        <!--ganreform-->
        <div v-if="is_ganre" class="add">
        <div class="lbl_add">Ganre add form</div>
          <p class="bg-danger" id="err" style="width: 100%">{{err_ganre}}</p>
          <div class="form-group">
            <label for="inputGName">Name</label>
            <input type="text" class="form-control" id="inputGName" placeholder="Enter name" v-model="ganre_name">
          </div>
          <button  class="btn btn-primary">Add ganre</button>
        </div>
        <!--end ganreform-->

      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'general_admin',
  data () {
    return {
       config: {
          headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      },
      err_author: "",
      name: "",
      surname: "",
      is_author: false,
      author: "",
      authors: {},

      err_ganre: "",
      ganre_name: "",
      is_ganre: false,
      ganre: "",
      ganres: {}

    }
  },
  created(){
    var self = this
      //axios.get('http://localhost:88/BOOK_SHOP/client/api/author/', this.config)
      axios.get('http://192.168.0.15/~user15/BOOK_SHOP/client/api/author/', this.config)
            .then(function (response) {
              console.log(response.data);
                self.authors = response.data['data']
      })
      .catch(function (error) {
        console.log(error);
      });

      axios.get('http://192.168.0.15/~user15/BOOK_SHOP/client/api/ganre/', this.config)
            .then(function (response) {
              console.log(response.data);
                self.ganres = response.data['data']
      })
      .catch(function (error) {
        console.log(error);
      });
  },
  methods:{
    addFormOpenAuthor(){
      this.is_author = !this.is_author
    },
    changeSelectAuthor(){

    },
    addFormOpenGanre(){
      this.is_ganre = !this.is_ganre
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.general{
  text-align: left;
}

.add{
  border: 1px solid lightgray;
  border-radius: 5px;
  padding:20px;
  margin-bottom:20px;
}

.lbl_add{
  text-align:right;
  font-weight:bold;
  text-decoration:underline;
}
</style>
