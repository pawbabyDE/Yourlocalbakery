<?php include('partials-front/menu.php'); ?>
<style type="text/css">
  /* Define table styles */
  .tg {
    /* Set the table border collapsing behavior */
    border-collapse: collapse;
    border-color: #aabcfe;
    border-spacing: 0;
    margin: 0px auto;
  }

  /* Define table cell (data cell) styles */
  .tg td {
    background-color: #e8edff;
    border-color: #aabcfe;
    border-style: solid;
    border-width: 1px;
    color: #669;
    font-family: Arial, sans-serif;
    font-size: 14px;
    /* Hide content that overflows the cell */
    overflow: hidden;
    padding: 10px 5px;
    word-break: normal;
  }

  /* Define table header cell styles */
  .tg th {
    background-color: #b9c9fe;
    border-color: #aabcfe;
    border-style: solid;
    border-width: 1px;
    color: #039;
    font-family: Arial, sans-serif;
    font-size: 14px;
    font-weight: normal;
    /* Hide content that overflows the cell */
    overflow: hidden;
    padding: 10px 5px;
    word-break: normal;
  }

  /* Define a specific cell style with custom attributes */
  .tg .tg-x1q4 {
    border-color: inherit;
    font-size: 36px;
    font-style: italic;
    font-weight: bold;
    text-align: center;
    text-decoration: underline;
    vertical-align: middle;
  }

  /* Define another specific cell style with custom attributes */
  .tg .tg-52ho {
    border-color: inherit;
    font-size: 36px;
    font-style: italic;
    font-weight: bold;
    text-align: center;
    text-decoration: underline;
    vertical-align: top;
  }

  /* Media query for responsive table design on small screens */
  @media screen and (max-width: 767px) {
    .tg {
      width: auto !important;
    }

    .tg col {
      width: auto !important;
    }

    .tg-wrap {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
      margin: auto 0px;
    }
  }
</style>
<div class="tg-wrap">
  <table class="tg">
    <tbody>
      <!-- Table Row 1 -->
      <tr>
        <td class="tg-x1q4" colspan="2" rowspan="2">email-kontaktowy</td>
        <td class="tg-52ho" colspan="13" rowspan="2">GoodFood@order.com</td>
      </tr>
      <tr>
      </tr>
      <!-- Table Row 2 -->
      <tr>
        <td class="tg-52ho" colspan="2" rowspan="2">Numer Telefonu</td>
        <td class="tg-52ho" colspan="13" rowspan="2">2137</td>
      </tr>
      <tr>
      </tr>
      <!-- Table Row 3 -->
      <tr>
        <td class="tg-52ho" colspan="2" rowspan="2">FB</td>
        <td class="tg-52ho" colspan="13" rowspan="2">FB.COM/GoodFood</td>
      </tr>
      <tr>
      </tr>
    </tbody>
  </table>
</div>

<?php include('partials-front/footer.php'); ?>