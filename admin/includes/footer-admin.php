  </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- summernote-js -->
    <script src="summernote/summernote.min.js"></script>

    <!-- include summernote-ko-KR -->
    <script src="summernote/lang/summernote-ko-KR.js"></script>

    <!-- custom script -->
    <script src="js/scripts.js"></script>

    <script type="text/javascript">
      google.charts.load('44', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          ['Views',       <?php echo $session->count; ?>],
          ['Comment',      <?php echo Comment::all_count(); ?>],
          ['Users',       <?php echo User::all_count(); ?>],
          ['Photo',    <?php echo Photo::all_count(); ?>]
        ]);

        var options = {
          legend: 'none',
          pieSliceText: 'label',
          title: 'Admin Statistics',
          backgroundColor: 'transparent'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
    </script>



</body>

</html>
