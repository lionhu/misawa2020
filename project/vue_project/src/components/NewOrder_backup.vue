<template>
  <div class="form-widget">

    <div class="form-result"></div>

    <div class="row">
      <div class="col-lg-6">
        <form class="row" action="include/form.php" method="post" enctype="multipart/form-data">
          <div class="form-process"></div>
          <div class="col-12 form-group">
            <label>Name:</label>
            <input type="text" name="jobs-application-name" id="jobs-application-name" class="form-control required" value="" placeholder="Enter your Full Name">
          </div>
          <div class="col-12 form-group">
            <label>Email:</label>
            <input type="email" name="jobs-application-email" id="jobs-application-email" class="form-control required" value="" placeholder="Enter your Email">
          </div>
          <div class="col-12 form-group">
            <div class="row">
              <div class="col-md-6 form-group">
                <label>Phone:</label>
                <input type="text" name="jobs-application-phone" id="jobs-application-phone" class="form-control required" value="" placeholder="Enter your Phone">
              </div>
              <div class="col-md-6 form-group">
                <label>Location:</label>
                <input type="text" name="jobs-application-location" id="jobs-application-location" class="form-control" value="" placeholder="Enter your City as Location">
              </div>
              <div class="w-100"></div>
              <div class="col-md-6 form-group">
                <label>Date Of Birth:</label>
                <input type="text" class="form-control dobpicker required" name="jobs-application-date-of-birth" id="jobs-application-date-of-birth" value="" placeholder="MM/DD/YYYY" data-date-end-date="-18y">
              </div>
              <div class="col-md-6 form-group">
                <label>Gender:</label>
                <div class="btn-group btn-group-toggle d-flex" data-toggle="buttons">
                  <label class="btn btn-outline-secondary ls0 nott">
                    <input type="radio" name="jobs-application-gender" id="jobs-application-gender-male" autocomplete="off" value="Male"> Male
                  </label>
                  <label class="btn btn-outline-secondary ls0 nott">
                    <input type="radio" name="jobs-application-gender" id="jobs-application-gender-female" autocomplete="off" value="Female"> Female
                  </label>
                </div>
                <!-- <select class="form-control" name="jobs-application-gender" id="jobs-application-gender">
                  <option value="">-- Select One --</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select> -->
              </div>
              <div class="w-100"></div>
              <div class="col-md-6 form-group">
                <label>Type:</label>
                <select class="form-control required" name="jobs-application-type" id="jobs-application-type">
                  <option value="">-- Select One --</option>
                  <option value="Part-Time">Part-Time</option>
                  <option value="Full-Time">Full-Time</option>
                  <option value="Internship">Internship</option>
                  <option value="Freelance">Freelance</option>
                </select>
              </div>
              <div class="col-md-6 form-group">
                <label>Experience:</label>
                <select class="form-control required" name="jobs-application-experience" id="jobs-application-experience">
                  <option value="">-- Select One --</option>
                  <option value="Less than 1 Year">Less than 1 Year</option>
                  <option value="1-4 Years">1-4 Years</option>
                  <option value="4-7 Years">4-7 Years</option>
                  <option value="7+ Years">7+ Years</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label>Upload CV:</label>
              <input type="file" id="jobs-application-resume" name="jobs-application-resume" class="file-loading required" data-show-preview="false" />
            </div>
            <div class="form-group">
              <label>Describe Yourself:</label>
              <textarea name="jobs-application-message" id="jobs-application-message" class="form-control required" cols="30" rows="10"></textarea>
            </div>
          </div>
          <div class="col-12 hidden">
            <input type="text" id="jobs-application-botcheck" name="jobs-application-botcheck" value="" />
          </div>
          <div class="col-12">
            <button type="submit" name="jobs-application-submit" class="btn btn-secondary">Send Message</button>
          </div>

          <input type="hidden" name="prefix" value="jobs-application-">
        </form>
      </div>
    </div>

  </div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import { Upload } from 'element-ui';
  import 'element-ui/lib/theme-chalk/index.css';

  export default {
    name: 'app',
    components:{
        elUpload: Upload
    },
    data () {
      return {
        msg: 'Welcome to Your Vue.js',
        news_china:"",
        date:"",
        min_date:"",
        tableData: [{
            date: '2016-05-02',
            name: '王小虎',
            address: '上海市普陀区金沙江路 1518 弄'
          }, {
            date: '2016-05-04',
            name: '王小虎',
            address: '上海市普陀区金沙江路 1517 弄'
          }, {
            date: '2016-05-01',
            name: '王小虎',
            address: '上海市普陀区金沙江路 1519 弄'
          }, {
            date: '2016-05-03',
            name: '王小虎',
            address: '上海市普陀区金沙江路 1516 弄'
          }]
      }
    },
    computed:{
      // token(){
      //         return this.$store.state.system.token;
      // },
    },
    created() {
      console.log("output from  test.vue");
    },
    methods: {
      
    }
  }
</script>

<style lang="scss">
.item-group {
  color: white
}
</style>