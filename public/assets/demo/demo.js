demo = {
  getData: function () {


    $.ajax({
      url: "/judevicestate/public/index.php/data",
    }).done(function (data) {

      //topcard
      $('#alldevice').html(data.totalhost);
      $('#runningdevice').html(data.upcount);
      $('#downdevice').html(data.downcount);


      //table down 
      $tables = renderError(data.datadown);
      $('#downdevicetable1').html($tables[0]);
      $('#downdevicetable2').html($tables[1]);
      $('#downdevicetable3').html($tables[2]);

      //table core device
      $tables2 = renderup(data.hostlist);
      $('#coredevicetable').html($tables2);

    });

    



  },



 

}

function renderError(errordata) {
  $errortablel = "";
  $errortable2 = "";
  $errortable3 = "";
  $count = 0;
  errordata.forEach(element => {
    $count = $count + 1;
    if ($count <= 20) {
      $errortablel = $errortablel + " <tr class='p-1 text-center'><td>" + element.display_name + "</td></tr > ";
    } else if ($count <= 30) {
      $errortable2 = $errortable2 + " <tr class='p-1 text-center'><td>" + element.display_name + "</td></tr> ";
    }
// else {
  //    $errortable3 = $errortable3 + " <tr class='p-1 text-center'><td>" + element.display_name + "</td></tr> ";

    //}

  });

  $both = [$errortablel, $errortable2, $errortable3];

  return $both;


}


function renderup(updata) {
  $core = ["JUMCCS01", "JUMCFW01", "JU-MC-DS01", "JU-MC-DS02", "JU-MC-DS03", "JU-MC-DS04", "JU-KC-FW01", "ju-sh-ds01", "JU-KC-CS01", "JU-KC-DS01", "JU-CAVM-CS01", "JU-CAVM-DS01"];


  $uptablel = "";


  updata.forEach(element => {




    if ($core.includes(element.display_name)) {
      $uptablel = $uptablel + " <tr class='p-1 text-center" + (element.current_state == '0' ? " bg-success" : " bg-danger") + "'><td>" + element.display_name + "</td><td>" + (element.current_state == '0' ? "UP" : "DOWN") + "</td></tr> ";
    }

  });

  return $uptablel;


}

