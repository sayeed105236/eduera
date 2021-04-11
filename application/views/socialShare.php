<!-- Share modal start-->
<!-- Modal -->
<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Share this course</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="input-group mb-3">
            <input type="text" value="" class="form-control" id="myInput" >
            <div class="input-group-append ">
              <span class="input-group-text" onclick="copyLink()">Copy</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <div id="shareButton"></div>
            </div>

        </div>

      </div>

    </div>
  </div>
</div>
<!-- Share modal end -->


<div class="modal fade" id="shareCertificateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Share this certificate</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="input-group mb-3">
            <input type="text" value="" class="form-control" id="myCertificateURL" >
            <div class="input-group-append">
              <span class="input-group-text" onclick="copyCertificateLink()">Copy</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <div id="shareCertificateButton"></div>
            </div>

        </div>

      </div>

    </div>
  </div>
</div>
