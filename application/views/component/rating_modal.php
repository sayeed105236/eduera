<!-- Start Showing preview video -->
<?php if($this->session->userdata('user_id')){?>
<div class="modal left fade video-dialog bd-example-modal-lg" id="ReviewPreviewModal" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span id="vimeo_player_title"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
               
            </div>
            <div class="modal-body">

                <div class="review-preview-video-wrap" >
                   <h4 style="text-align: center;color: #D12B66;" class="text-auto">How would you rate this course?</h4>
                   <div class="stars">
                    
                            <input class="stars__checkbox" type="radio" id="fifth-star" name="star" value="five">
                            <label class="stars__star" for="fifth-star">
                                <svg class="stars__star-icon star_icon_1" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 53.867 53.867" style="enable-background:new 0 0 53.867 53.867;" xml:space="preserve">
                                    <polygon points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798 
                                        10.288,52.549 13.467,34.013 0,20.887 18.611,18.182 "/>
                                </svg>
                            </label>

                            <input class="stars__checkbox" type="radio" id="fourth-star" name="star" value="four">
                            <label class="stars__star" for="fourth-star">
                                <svg class="stars__star-icon star_icon_2" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 53.867 53.867" style="enable-background:new 0 0 53.867 53.867;" xml:space="preserve">
                                    <polygon points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798 
                                        10.288,52.549 13.467,34.013 0,20.887 18.611,18.182 "/>
                                </svg>
                            </label>

                            <input class="stars__checkbox" type="radio" id="third-star" name="star" value="three">
                            <label class="stars__star" for="third-star">
                                <svg class="stars__star-icon star_icon_3" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 53.867 53.867" style="enable-background:new 0 0 53.867 53.867;" xml:space="preserve">
                                    <polygon points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798 
                                        10.288,52.549 13.467,34.013 0,20.887 18.611,18.182 "/>
                                </svg>
                            </label>
                            
                            <input class="stars__checkbox" type="radio" id="second-star" name="star" value="two">
                            <label class="stars__star" for="second-star">
                                <svg class="stars__star-icon star_icon_4" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 53.867 53.867" style="enable-background:new 0 0 53.867 53.867;" xml:space="preserve">
                                    <polygon points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798 
                                        10.288,52.549 13.467,34.013 0,20.887 18.611,18.182 "/>
                                </svg>
                            </label>

                           <input class="stars__checkbox" type="radio" id="first-star" name="star" value="one">
                           <label class="stars__star" for="first-star">
                               <svg class="stars__star-icon star_icon_5" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                   viewBox="0 0 53.867 53.867" style="enable-background:new 0 0 53.867 53.867;" xml:space="preserve">
                                   <polygon points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798 
                                       10.288,52.549 13.467,34.013 0,20.887 18.611,18.182 "/>
                               </svg>
                           </label>
                         <br>
                         <div class="form-group">
                             <h6 style="text-align: center;" id="rating-title"></h6>
                         </div>
                          
                            <div class="review-section" style="display: none; text-align: center;margin-top: 10px;">
                                <div class="form-group">
                                    <textarea type="form-control" name="review"  id="review" style="height: 150px !important;width: 400px !important;padding: 10px;" placeholder="Tell us about your own personal experience taking this course. Was it a good match for you?" ></textarea> 
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-light review-btn" type="button" >Save & Continue</button>
                                </div>
                            </div>
                       </div>

                       
                </div>
            </div>
        </div>
    </div>
</div>

<?php }?>

<!-- Start Showing preview video -->
<!-- <div class="modal left fade video-dialog bd-example-modal-lg" id="EditReviewPreviewModal" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title">
                    <span id="vimeo_player_title"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
               
            </div>
            <div class="modal-body">

                <div class="review-preview-video-wrap" >
                   <h4 style="text-align: center;color: #D12B66;" class="text-auto">How would you rate this course?</h4>
                   <div class="stars">
                    
                            <input class="stars__checkbox" type="radio"  id="fifth-stars" name="star" value="five">
                            <label class="stars__star" for="fifth-star">
                                <svg class="stars__star-icon" version="1.1" id="Capas_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 53.867 53.867" style="enable-background:new 0 0 53.867 53.867;" xml:space="preserve">
                                    <polygon points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798 
                                        10.288,52.549 13.467,34.013 0,20.887 18.611,18.182 "/>
                                </svg>
                            </label>

                            <input class="stars__checkbox" type="radio" id="fourth-stars" name="star" value="four">
                            <label class="stars__star" for="fourth-star">
                                <svg class="stars__star-icon" version="1.1" id="Capas_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 53.867 53.867" style="enable-background:new 0 0 53.867 53.867;" xml:space="preserve">
                                    <polygon points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798 
                                        10.288,52.549 13.467,34.013 0,20.887 18.611,18.182 "/>
                                </svg>
                            </label>

                            <input class="stars__checkbox" type="radio" id="third-stars" name="star" value="three">
                            <label class="stars__star" for="third-star">
                                <svg class="stars__star-icon" version="1.1" id="Capas_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 53.867 53.867" style="enable-background:new 0 0 53.867 53.867;" xml:space="preserve">
                                    <polygon points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798 
                                        10.288,52.549 13.467,34.013 0,20.887 18.611,18.182 "/>
                                </svg>
                            </label>
                            
                            <input class="stars__checkbox" type="radio" id="second-stars" name="star" value="two">
                            <label class="stars__star" for="second-star">
                                <svg class="stars__star-icon" version="1.1" id="Capas_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 53.867 53.867" style="enable-background:new 0 0 53.867 53.867;" xml:space="preserve">
                                    <polygon points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798 
                                        10.288,52.549 13.467,34.013 0,20.887 18.611,18.182 "/>
                                </svg>
                            </label>

                           <input class="stars__checkbox" type="radio" id="first-stars" name="star" value="one">
                           <label class="stars__star" for="first-star">
                               <svg class="stars__star-icon" version="1.1" id="Capas_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                   viewBox="0 0 53.867 53.867" style="enable-background:new 0 0 53.867 53.867;" xml:space="preserve">
                                   <polygon points="26.934,1.318 35.256,18.182 53.867,20.887 40.4,34.013 43.579,52.549 26.934,43.798 
                                       10.288,52.549 13.467,34.013 0,20.887 18.611,18.182 "/>
                               </svg>
                           </label>
                         <br>
                         <div class="form-group">
                             <h6 style="text-align: center;" id="edit-rating-title"></h6>
                         </div>
                          
                            <div class="review-section" style="text-align: center;margin-top: 10px;">
                                <div class="form-group">
                                    <textarea type="form-control" name="review" class="text_review" id="review" style="height: 150px !important;width: 400px !important;padding: 10px;" placeholder="Tell us about your own personal experience taking this course. Was it a good match for you?" ></textarea> 
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-light review-btn" type="button" >Save & Continue</button>
                                </div>
                            </div>
                       </div>

                       
                </div>
            </div>
        </div>
    </div>
</div> -->


<script type="text/javascript">
    $("label").click(function(){
        console
    })
</script>



