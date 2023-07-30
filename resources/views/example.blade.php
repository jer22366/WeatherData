<div id="cityNumber">
<select v-model="selected1">
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
  <option v-bind:value="10">臺北市</option>
  <option v-bind:value="11">新竹縣</option>
  <option v-bind:value="12">花蓮縣</option>
  <option v-bind:value="13">高雄市</option>
  <option v-bind:value="14">彰化縣</option>
  <option v-bind:value="15">新竹市</option>
  <option v-bind:value="16">新北市</option>
  <option v-bind:value="17">基隆市</option>
  <option v-bind:value="18">臺中市</option>
  <option v-bind:value="19">臺南市</option>
  <option v-bind:value="20">桃園市</option>
  <option v-bind:value="21">嘉義縣</option>
  <option v-bind:value="22">嘉義市</option>
</select>
<select v-model="selected2">
  <option disabled value="">請選擇</option>
  <option v-bind:value="1">當前天氣</option>
  <option v-bind:value="2">明後兩天預報</option>
  <option v-bind:value="3">一週天氣預報</option>
  <option v-bind:value="4">雨量查詢</option>
</select>
<table class="table">
  <thead>
    <tr>
      <template v-if = 'selected2 == 1'>城市:@{{cityid}} 溫度:@{{temp}} 時間:@{{timeNow}}</template>
      <template v-if = 'selected2 == 2'>
        城市:@{{cityid}}
        <template v-for="lists in first">
          <p>
            溫度:@{{ lists.descriptionT }} 天氣:@{{ lists.Description }} 開始時間:@{{ lists.startTime }} 結束時間:@{{ lists.endTime }}
          </p>
        </template>
        <template v-for="lists in second">
          <p>
            溫度:@{{ lists.descriptionT }} 天氣:@{{ lists.Description }} 開始時間:@{{ lists.startTime }} 結束時間:@{{ lists.endTime }}
          </p>
        </template>
        <template v-for="lists in third">
          <p>
            溫度:@{{ lists.descriptionT }} 天氣:@{{ lists.Description }} 開始時間:@{{ lists.startTime }} 結束時間:@{{ lists.endTime }}
          </p>
        </template>
      </template>

      <template v-if = 'selected2 == 3'>
      
        <table>
          <th>城市 @{{cityid}}</th>
          <tr>
            <th>日</th>
            <th>最低溫</th>
            <th>最高溫</th>
          </tr>
          
          <tr v-for="(lists, listKey) in list" :key="listKey">
              <td>@{{ lists.day }}</td>
              <td>@{{ lists.minT }}</td>
              <td>@{{ lists.maxT }}</td>
          </tr>
        </table>
      </template>
      <template v-if = 'selected2 == 4'> 城市:@{{cityid}} 一小時雨量:@{{onehourRain}} 一天雨量:@{{onedayRain}} 日期:@{{timeNow}} </template>
    </tr>
  </thead>
</table>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2.7.10/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>

new Vue({ 
  el: '#cityNumber',
  data: function() {
    return{
      selected1: '',
      selected2: '',
      list: '',
      cityid: '', 
      temp: '', 
      timeNow: '',
      onehourRain: '', 
      onedayRain: '',
      first:'',
      second:'',
      third:'', 
    }
  },
  methods:{
    methodClass(value1, value2){
      switch (value2) {
        case 1:
          axios.post('/tempNow',{
            citynumber: value1,
            weather: value2
          })
          .then(response => {
            this.cityid = response.data['cityid'];
            this.temp = response.data['temp'];
            this.timeNow = response.data['timeNow'];
          })
          .catch(function (error) {
              console.log(error.data);
          })

          break;
        case 2:
          axios.post('/twodayWeather',{
            citynumber: data1,
            weather: data2
          })
          .then(response => {
            this.cityid = response.data[0]['cityid'];
            this.first = response.data.slice(0,8);
            this.second = response.data.slice(9,17);
            this.third = response.data.slice(17,24);
          })
          .catch(function (error) {
              console.log(error.data);
          })

          break;

        case 3:
          axios.post('/oneweekweather',{
            citynumber: data1,
            weather: data2
          })
          .then(response => {
              this.cityid = response.data[1]['cityid'];
              this.list = response.data;
          })
          .catch(function (error) {
              console.log(error.data);
          })

          break;

        case 4:
          axios.post('/rain',{
            citynumber: data1,
            weather: data2
          })
          .then(response => {
            this.cityid = response.data['cityid'];
            this.onehourRain = response.data['onehourRain'];
            this.onedayRain = response.data['onedayRain'];
            this.timeNow = response.data['timeNow'];
          })
          .catch(function (error) {
              console.log(error.data);
          })
          break;
      }
    }
  },
  mounted: function () {
    this.methodClass(this.value1, this.value2)
  },
  watch:{
    selected1: function(newValue){
      data1 = newValue;
      this.methodClass(data1, data2)
    },
    selected2: function(newValue){
      data2 = newValue;
      this.methodClass(data1, data2)
    }
  }
})

</script>

