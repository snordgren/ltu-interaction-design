    <!-- MODAL CONTENT STARTS HERE -->

    <!-- Inkluderar projektfiler-->
    <script type="text/javascript" src="order.js"></script>


    <div class="modal fade text-center" id="confirmModal" tabindex="-2" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"> </h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>

          </div>
          <div class="modal-body">
            <div>
              <p id="dialogMsg"> Do you really want to close? </p>  
            </div>


          </div>
          <div class="modal-footer">

            <button type="button" class="btn btn-secondary" data-dismiss="modal">Stäng</button>
            <!-- Vid klick så körs funktion från JS fil -->
            <button type="button" class="btn btn-primary" onclick="addToOrder()">Lägg Till i Order</button>

          </div>
        </div>
      </div>
    </div>

    <!-- END MODAL CONTENT -->