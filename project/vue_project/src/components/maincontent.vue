<template>
    <div class="box box-inverse bg-dark bg-hexagons-white">
      <div class="box-body">
        <h1 class="page-header text-center no-border font-weight-600 font-size-60 mt-25"><span class="text-yellow">Buy</span> and <span class="text-danger">Sell</span> Coins at the<br> Crypto without additional fees</h1>
        <h3 class="subtitle text-center ">Buy now and get +30% extra bonus Minimum pre-sale<br> amount 50 Crypto Coin. We accept BTC crypto-currency.</h3>
        <div class="row">
          <div class="col-12">
            <div class="exchange-calculator text-center mt-35">
              <input type="text" class="form-control" name="coins-exchange" placeholder="" value="10.1548">                
              <select class="coins-exchange" name="state">
                 <option value="BTC">BTC</option>
                 <option value="BTC">Ethereum</option>
                 <option value="Ripple">Ripple</option>
                 <option value="Ripple">Bitcoin Cash</option>
                 <option value="Ripple">Cardano</option>
                 <option value="Ripple">Litecoin</option>
                 <option value="Ripple">NEO</option>
                 <option value="Ripple">Stellar</option>
                 <option value="Ripple">EOS</option>
                 <option value="Ripple">NEM</option>
              </select>
              <div class="equal"> = </div>
              <input type="text" class="form-control" name="money-exchange" placeholder="" value="125.158">                
              <select class="money-exchange" name="state">
                 <option value="USD">USD</option>
                 <option value="EURO">EURO</option>
              </select>
             </div>
             <div class="text-center mt-15 mb-25">
              <a href="#" class="btn btn-yellow btn-lg mx-auto">EXCHANGE NOW</a>
             </div>

                <img v-if="imageUrl" :src="imageUrl" class="avatar">
                <input @change="selectedFile" type="file" name="file">


                  <button class="btn btn-primary" @click="show_data">Search Me</button>
                <p>{{token}}</p>
                <h1 class="lionhu">{{ msg }}</h1>
          </div>
        </div>
      </div>
    </div>


<!--     <div id="app1">
      <div class="row">
        <div class="col-lg-6">
              <VueCtkDateTimePicker 
                :format="'YYYY-MM-DD HH:mm:ss'" 
                :min-date = "start_date"
                label="期限の指定"
                v-model="date" name="uniquename">
            </VueCtkDateTimePicker>
        </div>
      </div> -->
<!-- 
        <img v-if="imageUrl" :src="imageUrl" class="avatar">
        <h1 class="lionhu">{{ msg }}</h1> -->
<!--         <ul>
          <li class="lionh"></li>
          <li class="lionh"></li>
          <li class="lionh"></li>
          <li class="lionh"></li>
          <li class="lionh"></li>
        </ul> -->


<!--         <input @change="selectedFile" type="file" name="file">


        <button class="btn btn-primary" @click="show_data">Search Me</button>
        <p>{{token}}</p>
        <input v-validate="'required|email'" name="email" type="text">
        <span>{{ errors.first('email') }}</span>
        <img src="/static/img/sample.jpg">
    </div> -->
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import getData from '../utils/index.js';
  import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
  import moment from 'moment'
  import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';



  export default {
    name: 'app',
    components:{
        VueCtkDateTimePicker,
    },
    data () {
      return {
        msg: 'Welcome to Your Vue.js',
        news_china:"",
        date:"",
        min_date:"",
        imageUrl: '',
        avatar:null
      }
    },
    computed:{
      token(){
              return this.$store.state.system.token;
      },
    },
    created() {
      this.fetchData();
      console.log("output from  App.vue");

      const default_date=moment().add(0,"days").hours(24)
      this.date=default_date.format('YYYY-MM-DDTHH:mm:ss')

      this.$store.dispatch("system/getToken");
    },
    computed:{
      start_date(){
        const start=moment().add(1,"days").hours(8)
        return start.format('YYYY-MM-DDTHH:mm:ss')
      },
      token(){
              return this.$store.state.system.token;
      },
    },
    methods: {
      async fetchData() {
        const data = await getData();
        this.msg = data;
      },
      selectedFile(e){
        e.preventDefault();
        let files = e.target.files;
        let file = files[0];

        const isJPG = file.type === 'image/jpeg' || file.type ==='image/png';
        const isLt2M = file.size / 1024 / 1024 < 2;

        if (!isJPG) {
          console.log('上传头像图片只能是 JPG 格式!');
        }
        if (!isLt2M) {
          console.log('上传头像图片大小不能超过 2MB!');
        }

        if (isJPG && isLt2M){
          this.avatar = file;
          this.imageUrl = URL.createObjectURL(this.avatar);

        }    
      },
      show_data(){
        
        let formData = new FormData();
        formData.append('avatar', this.avatar);
        formData.append("organization",'kinghu')
        formData.append("telephone",'0999090')
        let config = {
            headers: {
                'content-type': 'multipart/form-data'
            }
        };

        console.log(formData)

        axios.put('/api/userprofiles/1/',formData,config)
          .then((res)=>{
              console.log(res)
          }).catch(function(error){
              console.log(error)
          })


        // axios.post('/api/order/',
        //   {
        //     "amount": 0,
        //     "from_currency": "jpy",
        //     "to_currency": "rmb",
        //     "due_at": this.date,
        //     "rate": 0,
        //     "user_id": 1,
        //     "active": true,
        //     "privacy": "string",
        //     "send_notification": true
        // })
        //   .then((res)=>{
              
        //       console.log(res)
        //   }).catch(function(error){
        //       console.log(error)
        //   })

      },
      changeAvatar(file, fileList){
        this.avatar=file
        this.imageUrl = URL.createObjectURL(file.raw);
        
      },
      handleAvatarSuccess(res, file) {
        this.imageUrl = URL.createObjectURL(file.raw);
      },
      beforeAvatarUpload(file) {
        const isJPG = file.type === 'image/jpeg';
        const isLt2M = file.size / 1024 / 1024 < 2;

        if (!isJPG) {
          this.$message.error('上传头像图片只能是 JPG 格式!');
        }
        if (!isLt2M) {
          this.$message.error('上传头像图片大小不能超过 2MB!');
        }
        return isJPG && isLt2M;
      }
    }
  }
</script>

<style lang="scss">
    #app {
        font-family: "Avenir", Helvetica, Arial, sans-serif;

        h1 {
            color: #CC3333;
        }
    }

  //   .avatar-uploader .el-upload {
  //   border: 1px dashed #d9d9d9;
  //   border-radius: 6px;
  //   cursor: pointer;
  //   position: relative;
  //   overflow: hidden;
  // }
  // .avatar-uploader .el-upload:hover {
  //   border-color: #409EFF;
  // }
  // .avatar-uploader-icon {
  //   font-size: 28px;
  //   color: #8c939d;
  //   width: 178px;
  //   height: 178px;
  //   line-height: 178px;
  //   text-align: center;
  // }
  .avatar {
    width: 178px;
    height: 178px;
    display: block;
    border: 1px dashed #d9d9d9;
    border-color: #409EFF;
  }
</style>