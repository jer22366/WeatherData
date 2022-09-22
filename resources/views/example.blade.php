<div id="cityname">
    <select v-model="selected">
        <option disabled value="" >請選擇</option>
        <option v-bind:value="1">雲林縣</option>
        <option v-bind:value="2">南投縣</option>
        <option v-bind:value="3">連江縣</option>
        <option v-bind:value="4">臺東縣</option>
        <option v-bind:value="5">金門縣</option>
        <option v-bind:value="6">宜蘭縣</option>
        <option v-bind:value="7">屏東縣</option>
        <option v-bind:value="8">苗栗縣</option>
        <option v-bind:value="9">澎湖縣</option>
        <option v-bind:value="10">台北市</option>
        <option v-bind:value="11">新竹縣</option>
        <option v-bind:value="12">花蓮縣</option>
        <option v-bind:value="13">高雄市</option>
        <option v-bind:value="14">彰化縣</option>
        <option v-bind:value="15">新竹市</option>
        <option v-bind:value="16">新北市</option>
        <option v-bind:value="17">基隆市</option>
        <option v-bind:value="18">台中市</option>
        <option v-bind:value="19">台南市</option>
        <option v-bind:value="20">桃園市</option>
        <option v-bind:value="21">嘉義縣</option>
        <option v-bind:value="22">嘉義市</option>
    </select>
    <span>Selected: @{{ selected }}</span>
    <table class="table">
      <thead>
        <tr>
          <th>城市名</th>
          <th>到期日</th>
        </tr>
          <td>list: @{{ list }}</td>
      </thead>
    </table>
</div>

<div id="weather">
    <select v-model="selected">
        <option disabled value="">請選擇</option>
        <option >當前天氣</option>
        <option >一週天氣預報</option>
        <option >明後兩天預報</option>
        <option >雨量查詢</option>
    </select>
    <span>Selected: @{{ selected }}</span>
</div>


<script src="https://cdn.jsdelivr.net/npm/vue@2.7.10/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
new Vue({
  el: '#cityname',
  data: {
    selected: '',
    list: '',
  },
  watch:{
    selected: function(newValue){
      axios.post('/controllerTest',{
          number: newValue,
      })
        .then(response => {
          var resposeData = JSON.parse(response.data);
          this.list = resposeData;
        })
        .catch(function (error) {
            console.log(error.data);
        })
    }
  }
})

new Vue({
  el:'#weather',
  data:{
    selected:''
  }
})
</script>

