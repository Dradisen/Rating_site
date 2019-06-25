
new Vue({
    el: "#table",
    data: {
        rows: [],
        name: null,
        month: null,
        year: new Date().getFullYear(),
        month_verbal:{
            1: "Январь",
            2: "Февраль",
            3: "Март",
            4: "Апрель",
            5: "Май",
            6: "Июнь",
            7: "Июль",
            8: "Август",
            9: "Сентябрь",
            10: "Октябрь",
            11: "Ноябрь",
            12: "Декабрь",
        }
    },
    computed:{
        filtered: function(){
            var self = this;
            var name = self.name;
            var month = self.month;
            var year = self.year;

            return self.rows.filter(function(el){

                if(name==='' || name===null) return true;
                else return el.worker.toLowerCase().indexOf(name.toLowerCase()) > -1;
            }).filter(function(el){
                if(month==='' || month===null || month == 0) return true;
                else return el.month == month;
            }).filter(function(el){
                if(year==='' || year===null) return true;
                else return el.year == year;
            })
        }
    },
    mounted(){
        let self = this;
        axios.get(window.location.origin+'/admin/rating/api')
        .then((responce) => {
            self.rows = responce.data;
            self.month = responce.data[0].month;
         }).catch((error) => {
             console.log(error);
         });
    }

})