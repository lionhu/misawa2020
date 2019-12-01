<template>
<div>
    <h3>【特定商取引法に基づく表記】</h3>
    <table bgcolor="#999999" border="0" cellpadding="9" cellspacing="1" style="font-size:13px;text-align:left">
        <tr>
            <th >販売社名</th>
            <td >日栄株式会社</td>
        </tr>
        <tr>
            <th  >設立年月</th>
            <td >2019年6月</td>
        </tr>
        <tr>
            <th  >資本金</th>
            <td >500万円</td>
        </tr>
        <tr>
            <th  >運営統括責任者</th>
            <td >佐藤　淳一</td>
        </tr>
        <tr>
            <th  >所在地</th>
            <td >埼玉県さいたま市南区鹿手袋7−19−17</td>
        </tr>
        <tr>
            <th >電話番号</th>
            <td >048-708-6883</td>
        </tr>
        <tr>
            <th >メールアドレス</th>
            <td > crs@nichiei.services</td>
        </tr>
        <tr>
            <th >サービスURL</th>
            <td > https://www.exrate.world</td>
        </tr>
        <tr>
            <th >提供サービス</th>
            <td >【外貨両替】<br />
                　インターネットを経由し一般個人顧客に利便性が高い外貨両替マッチングサービスを提供致します。
                <br>現時点、日本円と中国元のみを取り扱っております。
            </td>
        </tr>
        <tr>
            <th >お支払い方法</th>
            <td >クレジットカード
                <br />銀行振込
                <br />
            </td>
        </tr>
        <tr>
            <th >商品引渡し方法</th>
            <td >当方にて手配後、運送会社による配送</td>
        </tr>
        <tr>
            <th >表現、及びサービスに関する注意書き</th>
            <td >本商品に示された表現や再現性には個人差があり、
                <br />必ずしも利益や効果を保証したものではございません。</td>
        </tr>
    </table>
</div>
</template>

<script>

  import {mapActions, mapState,mapGetters} from "vuex"
  import Swal from 'sweetalert2'

  export default {
    name: 'app',
    components:{
    },
    data () {
      return {
      }
    }
};

</script>

<style lang="scss">
table tr th{
  width:110px;
  background-color:rgb(47,47,47);
}

table tr td{
  background-color:rgb(47,47,47);
}
</style>