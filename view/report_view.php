
<html>
    <head>
 <?PHP       
 if(isset($plotting_data)){
//foreach($plotting_data as $row){
 // echo $row->t_start_date ."<br>" ;
  // echo $row->difftime."<br>" ;
  //   echo $row->tooltip_time."<br>";
 //  }
    $i=0;
      while($i <= 6)
      {
                foreach($plotting_data as $row)
                 {
                   if($row->t_start_date== $line_graph[$i])  {
                   $data[]= "['" .$row->t_start_date."' , ".$row->difftime.",'" . $row->tooltip_time. "']"; 
                   $i++;}
                 }
                 if($i==7) {break;} 
                 $data[] = "['" .$line_graph[$i]."',". 0 . ",'" .  0 . "']"; 
                 $i++ ; 
                }    
   $data_for_chart =implode(",\n",$data);
   var_dump($data_for_chart);
 }
   ?>
          <script type="text/javascript" src="https://www.google.com/jsapi"></script>
             <script src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
            <script type="text/javascript">
                 
              google.load("visualization", "1", {packages:["corechart"]});
              google.setOnLoadCallback(drawChart);
              function drawChart() {
               var data = new google.visualization.DataTable();
               data.addColumn('string','Start Date');
               data.addColumn('number','Time');
               data.addColumn({type:'string', role:'tooltip', 'p': {'html': true}});
               data.addRows([
               <?php if(isset($plotting_data)):?>
             <?php echo $data_for_chart;?> 
                 <?php endif ;?>
          ]);
            var options = {
                //legend : none,
                tooltip:{isHtml:true},
             title: 'Number of hour per day',
          hAxis: {title: 'Date', titleTextStyle: {color: 'blue'}},
          vAxis: { format: '#,###',viewWindowMode:'explicit',viewWindow: {min:0,max:8},gridlines: {count:7}}
            };
            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
            chart.draw(data, options);
          } 
           </script>
       <script type="text/javascript">
       $(function(){
       $('#simple').on('click','li a',function(){
           var content = $(this).text();
            $('#go').val(content);
        });  
        
       $('#go').click(function(){
             var base_url = '<?php echo site_url();?>';
             alert(base_url);
              $.ajax({
               url:base_url + "/report/show_more_wp",
               success:function(result){
               data = eval("(" + result + ")");
              console.log(result[0]);
              data=JSON.parse(result);
               var  output = ''; 
               var  add ="add new workspace";
               JSON.stringify(result);
               $.each(data.more_wp,function(i,item){
               output += "<li><a href='#'>" +item.w_name+ "</a></li>";
                });
               output+="<li><a href = '" +base_url+ "/workspace'>" + add +"</a></li>";
               console.log(output);
               $("#simple").append(output);
                                       }
                      });
       });
});
</script>
        <style type='text/css'>
                 #menu{
               height: 50px;
               width: 100%;
               background-color: #DFDDDD;
            } 
            #sub_menu{
            height:50px;
            width:100%;
            background-color: #eeeeee;
            
            }
            
            #menu ul{
                float: right;
            }
          #menu  ul li{
            list-style-type: none;
            display: inline;
            padding:  0 10px;
            }
            #menu ul li a:hover{
               color:#777;
            }  
           #menu ul li a{
                height:35px;
                color: #777;
                width: auto;
                text-decoration: none;}
           #sub_menu ul li {
                height:25px;
                border: solid 1px black;
                width: 160px;
               background-color:#DFDDDD;
           }
           #sub_menu ul li{
               list-style-type: none;
           }
           #sub_menu ul{
               margin-top: -25px;
               margin-left: 70px;
           } 
          #sub_menu ul li a
         {
           text-decoration: none;
        }
        #sub_menu ul li  a:before {
    color: #B2B2B2;
    content: "► ";
    display: inline-block;
}
           </style> 
            <title></title>      
    </head>
    <body>
        <div id="div1"></div>
           <div id="menu">
            <ul>
                <li><a href ="<?php  echo site_url('track/display_message');?>">Home</a></li>
                <li><a href = "<?php  echo site_url('report/show');?>">Report</a></li>
                <li><a href="">Setting</a></li>
                <li><a href="<?php  echo site_url('logout/user_logout');?>">Logout</a></li>
            </ul>
        </div>
        <div id='sub_menu'>
            <label style="padding-left:20px; line-height:400%;font-size:1.2em; color:#00620C;">Workspace</label>
            <input id="go" style="color:#767776; background-color:#E3ECE3; border:none;" type="submit" value='More Workspace ~' 
                    onsubmit="true"/>
                <ul id="simple"></ul> 
        </div>
        <div></div>
        <div  style=" margin-top: 100px">
            <fieldset  style="width:900px; height:500px">
                <form action= 'http://localhost/ci/index.php/line_old/line_plot' method ="POST">
              <P> <input type ="Submit" name="submit" value=" Show Week Work"></P>
             <div id="chart_div" style="width: 800px; height: 400px;"></div>
             </form>
            </fieldset>
        </div>
           
    </body>
</html>
