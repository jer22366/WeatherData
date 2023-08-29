<style>
#weather{
  text-align: center;
}
#cityNumber{
  display: flex;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
  width: 100%;
}
.table{
  display: flex;
  width: 100%;
  justify-content: center;
  table-layout: fixed;
  text-align:center;
  vertical-align:middle;
}
.table th, .table td {
  padding: 10px; 
  min-width: 120px;
} 
.toggle-button{
  cursor: pointer;
  background-color: unset;
  border:unset;
  font-size: large;
}
.toggle-button:hover{
  font-size: 25px;
}
#selected{
  display: flex; 
  align-items: center; 
  margin-bottom: 10px;
}
#weatherData{
  display: flex;
  width: 100%;
  justify-content: center;
  align-content: flex-end;
  flex-direction: row;
  flex-wrap: wrap;
}
#button{
  display: flex; 
  justify-content: center; 
  width: 100%; 
  margin-bottom: 10px;
}
#selectedText{
  margin-right: 10px;
}
</style>

<div id="weather">
  天氣預報
</div>
<div id="cityNumber">

  <div id="selected">
    <div id="selectedText">請選擇城市:</div>
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
  
    <div id="selectedText">請選擇:</div>
    <select v-model="selected2">
    <option disabled value="">請選擇</option>
    <option v-bind:value="1">當前天氣</option>
    <option v-bind:value="2">未來兩天天氣詳細資訊</option>
    <option v-bind:value="3">一週天氣預報</option>
    <option v-bind:value="4">雨量查詢</option>
    </select>
  </div>
  
  <div id="weatherData">
    <template v-if = 'selected2 == 1'>城市:@{{cityid}} 溫度:@{{temp}}</template>

    <template v-if = 'selected2 == 2'>
  
      <div id="button">
        <button class="toggle-button" @click.stop="showOrHide('first')">今日 @{{showorhiddenFirst}}</button>
        <button class="toggle-button" @click.stop="showOrHide('second')">明日 @{{showorhiddenSecond}}</button>
        <button class="toggle-button" @click.stop="showOrHide('third')">後日@{{showorhiddenThird}}</button>
      </div>

      <table class="table">
        城市:@{{cityid}}
        <tr>
          <th>開始時間</th>
          <th>結束時間</th>  
          <th>溫度</th>
          <th>天氣</th>
          <th>降雨機率</th>
        </tr>

        <template v-for="lists in first">
          <tr v-if="showFirst">
            <td>@{{ lists.startTime }}</td> 
            <td>@{{ lists.endTime }}</td>
            <td>@{{ lists.temp }} @{{ lists.tempFeel }}</td> 
            <td>@{{ lists.weather }}</td> 
            <td>@{{ lists.rainProbability }}</td>  
          </tr>
        </template>

        <template v-for="lists in second">
          <tr v-if="showSecond">
            <td>@{{ lists.startTime }}</td> 
            <td>@{{ lists.endTime }}</td>
            <td>@{{ lists.temp }} @{{ lists.tempFeel }}</td> 
            <td>@{{ lists.weather }}</td> 
            <td>@{{ lists.rainProbability }}</td>  
          </tr>
        </template>

        <template v-for="lists in third">
          <tr v-if="showThird">
            <td>@{{ lists.startTime }}</td> 
            <td>@{{ lists.endTime }}</td>
            <td>@{{ lists.temp }} @{{ lists.tempFeel }}</td> 
            <td>@{{ lists.weather }}</td> 
            <td>@{{ lists.rainProbability }}</td>  
          </tr>
        </template>
      </table>
    </template>

    <template v-if = 'selected2 == 3'>
      <table class="table">
        城市 @{{cityid}}
        <tr>
          <th>開始時間</th>
          <th>結束時間</th>
          <th>最低溫</th>
          <th>最高溫</th>
        </tr>
        <tr v-for="(lists, listKey) in list" :key="listKey">
          <td>@{{ lists.startTime }}</td>
          <td>@{{ lists.endTime }}</td>
          <td>@{{ lists.minT }}</td>
          <td>@{{ lists.maxT }}</td>
        </tr>
      </table>
    </template>

    <template v-if = 'selected2 == 4'> 城市:@{{cityid}} 一小時雨量:@{{onehourRain}} 一天雨量:@{{onedayRain}} 日期:@{{timeNow}} </template>
  </div>
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
      showFirst: true,
      showSecond: false,
      showThird: false,
      showorhiddenFirst:'-',
      showorhiddenSecond:'+',
      showorhiddenThird:'+',
    }
  },
  methods:{
    showOrHide(section) {
      if (section === 'first') {
        this.showFirst = !this.showFirst; // 切换显示状态
        if(this.showorhiddenFirst == '-'){
          this.showorhiddenFirst = '+';
        }
        else{
          this.showorhiddenFirst = '-';
        }
      }
      if (section === 'second') {
        this.showSecond = !this.showSecond; // 切换显示状态
        if(this.showorhiddenSecond == '+'){
          this.showorhiddenSecond = '-';
        }
        else{
          this.showorhiddenSecond = '+';
        }
      }
      if (section === 'third') {
        this.showThird = !this.showThird; // 切换显示状态
        if(this.showorhiddenThird == '+'){
          this.showorhiddenThird = '-';
        }
        else{
          this.showorhiddenThird = '+';
        }
      }
      // 可以添加其他部分的切换逻辑...
    },
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