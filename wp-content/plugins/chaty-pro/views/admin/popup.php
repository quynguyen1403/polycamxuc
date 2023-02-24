<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="chaty-popup" id="custom-message-popup">
    <div class="chaty-popup-outer"></div>
    <div class="chaty-popup-inner popup-pos-bottom">
        <div class="chaty-popup-content">
            <div class="chaty-popup-close">
                <a href="javascript:void(0)" class="close-delete-pop close-chaty-popup-btn relative top-2 right-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M15.6 15.5c-.53.53-1.38.53-1.91 0L8.05 9.87 2.31 15.6c-.53.53-1.38.53-1.91 0s-.53-1.38 0-1.9l5.65-5.64L.4 2.4C-.13 1.87-.13 1.02.4.49s1.38-.53 1.91 0l5.64 5.63L13.69.39c.53-.53 1.38-.53 1.91 0s.53 1.38 0 1.91L9.94 7.94l5.66 5.65c.52.53.52 1.38 0 1.91z"/></svg>
                </a>
            </div>
            <div class="a-card a-card--normal">
                <div class="chaty-popup-header font-medium text-cht-gray-150 py-4 text-left px-5">
                    No channel was selected
                </div>
                <div class="text-cht-gray-150 text-base px-5 py-6">
                    Please select at least one chat channel before publishing your widget
                </div>
                <input type="hidden" id="delete_widget_id" value="">
                <div class="chaty-popup-footer flex px-5">
                    <button type="button" class="close-chaty-popup-btn channel-setting-btn btn btn-primary rounded-lg mr-5">Change Number</button>
                    <button type="button" class="btn btn-default check-for-numbers btn btn-primary btn rounded-lg btn-primary bg-transparent text-cht-gray-150 border-cht-gray-150 hover:bg-transparent hover:text-cht-gray-150">Save Anyway</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="chaty-popup" id="no-device-popup">
    <div class="chaty-popup-outer"></div>
    <div class="chaty-popup-inner popup-pos-bottom">
        <div class="chaty-popup-content">
            <div class="chaty-popup-close">
                <a href="javascript:void(0)" class="close-delete-pop close-chaty-popup-btn relative top-2 right-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M15.6 15.5c-.53.53-1.38.53-1.91 0L8.05 9.87 2.31 15.6c-.53.53-1.38.53-1.91 0s-.53-1.38 0-1.9l5.65-5.64L.4 2.4C-.13 1.87-.13 1.02.4.49s1.38-.53 1.91 0l5.64 5.63L13.69.39c.53-.53 1.38-.53 1.91 0s.53 1.38 0 1.91L9.94 7.94l5.66 5.65c.52.53.52 1.38 0 1.91z"/></svg>
                </a>
            </div>
            <div class="a-card a-card--normal">
                <div class="chaty-popup-header font-medium text-cht-gray-150 py-4 text-left px-5">
                    No channel was selected
                </div>
                <div class="text-cht-gray-150 text-base px-5 py-6">
                    Please select at least one chat channel before publishing your widget
                </div>
                <input type="hidden" id="delete_widget_id" value="">
                <div class="chaty-popup-footer flex px-5">
                    <button type="button" class="close-chaty-popup-btn channel-setting-btn btn btn-primary rounded-lg mr-5">Select Channel</button>
                    <button type="button" class="btn btn-default check-for-triggers btn btn-primary btn rounded-lg btn-primary bg-transparent text-cht-gray-150 border-cht-gray-150 hover:bg-transparent hover:text-cht-gray-150">Save Anyway</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="chaty-popup" id="agent-value-popup">
    <div class="chaty-popup-outer"></div>
    <div class="chaty-popup-inner popup-pos-bottom">
        <div class="chaty-popup-content">
            <div class="chaty-popup-close">
                <a href="javascript:void(0)" class="close-delete-pop close-chaty-popup-btn right-2 top-2 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M15.6 15.5c-.53.53-1.38.53-1.91 0L8.05 9.87 2.31 15.6c-.53.53-1.38.53-1.91 0s-.53-1.38 0-1.9l5.65-5.64L.4 2.4C-.13 1.87-.13 1.02.4.49s1.38-.53 1.91 0l5.64 5.63L13.69.39c.53-.53 1.38-.53 1.91 0s.53 1.38 0 1.91L9.94 7.94l5.66 5.65c.52.53.52 1.38 0 1.91z"/></svg>
                </a>
            </div>
            <div class="a-card a-card--normal">
                <div class="chaty-popup-header text-left font-primary text-cht-gray-150 font-medium p-5 relative">
                    Fill out all agent name
                </div>
                <div class="chaty-popup-body text-cht-gray-150 text-base px-5 py-6">
                    One or more agent name is missing.
                </div>
                <input type="hidden" id="delete_widget_id" value="">
                <div class="chaty-popup-footer flex px-5">
                    <button type="button" class="btn-default check-for-triggers btn rounded-lg btn-primary bg-transparent text-cht-gray-150 border-cht-gray-150 hover:bg-transparent hover:text-cht-gray-150 mr-5">Save Anyway</button>
                    <button type="button" class="close-chaty-popup-btn fill-agent-value btn rounded-lg">Fill agent details</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="chaty-popup" id="no-step-device-popup">
    <div class="chaty-popup-outer"></div>
    <div class="chaty-popup-inner popup-pos-bottom">
        <div class="chaty-popup-content">
            <div class="chaty-popup-close">
                <a href="javascript:void(0)" class="close-delete-pop close-chaty-popup-btn relative top-5 right-5">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M15.6 15.5c-.53.53-1.38.53-1.91 0L8.05 9.87 2.31 15.6c-.53.53-1.38.53-1.91 0s-.53-1.38 0-1.9l5.65-5.64L.4 2.4C-.13 1.87-.13 1.02.4.49s1.38-.53 1.91 0l5.64 5.63L13.69.39c.53-.53 1.38-.53 1.91 0s.53 1.38 0 1.91L9.94 7.94l5.66 5.65c.52.53.52 1.38 0 1.91z"/></svg>
                </a>
            </div>
            <div class="a-card a-card--normal">
                <div class="chaty-popup-header font-semibold text-cht-gray-150 py-4 text-left px-5">
                    No channel was selected
                </div>
                <div class="text-cht-gray-150 text-base px-5 py-6">
                    Please select at least one chat channel before publishing your widget
                </div>
                <input type="hidden" id="delete_widget_id" value="">
                <div class="chaty-popup-footer flex px-5">
                    <button type="button" class="btn-default close-chaty-popup-btn next-step-btn btn rounded-lg btn-primary bg-transparent text-cht-gray-150 border-cht-gray-150 hover:bg-transparent hover:text-cht-gray-150 mr-5">Ok</button>
                    <button type="button" class="close-chaty-popup-btn channel-setting-step-btn btn rounded-lg">Select Channel</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="chaty-popup" id="no-device-value">
    <div class="chaty-popup-outer"></div>
    <div class="chaty-popup-inner popup-pos-bottom">
        <div class="chaty-popup-content">
            <div class="chaty-popup-close">
                <a href="javascript:void(0)" class="close-delete-pop close-chaty-popup-btn relative top-4 right-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M15.6 15.5c-.53.53-1.38.53-1.91 0L8.05 9.87 2.31 15.6c-.53.53-1.38.53-1.91 0s-.53-1.38 0-1.9l5.65-5.64L.4 2.4C-.13 1.87-.13 1.02.4.49s1.38-.53 1.91 0l5.64 5.63L13.69.39c.53-.53 1.38-.53 1.91 0s.53 1.38 0 1.91L9.94 7.94l5.66 5.65c.52.53.52 1.38 0 1.91z"/></svg>
                </a>
            </div>
            <div class="a-card a-card--normal">
                <div class="chaty-popup-header font-medium text-cht-gray-150 py-4 text-left px-5">
                    Fill out at least one channel details
                </div>
                <div class="text-cht-gray-150 text-base px-5 py-6">
                    You need to fill out at least one channel details for Chaty to show up on your website
                </div>
                <input type="hidden" id="delete_widget_id" value="">
                <div class="chaty-popup-footer flex px-5">
                    <button type="button" class="btn-default check-for-triggers btn rounded-lg btn-primary bg-transparent text-cht-gray-150 border-cht-gray-150 hover:bg-transparent hover:text-cht-gray-150 mr-5">Save Anyway</button>
                    <button type="button" class="close-chaty-popup-btn channel-setting-btn btn rounded-lg">Fill channel details</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="chaty-popup" id="no-step-device-value">
    <div class="chaty-popup-outer"></div>
    <div class="chaty-popup-inner popup-pos-bottom">
        <div class="chaty-popup-content">
            <div class="chaty-popup-close">
                <a href="javascript:void(0)" class="close-delete-pop close-chaty-popup-btn relative top-2 right-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M15.6 15.5c-.53.53-1.38.53-1.91 0L8.05 9.87 2.31 15.6c-.53.53-1.38.53-1.91 0s-.53-1.38 0-1.9l5.65-5.64L.4 2.4C-.13 1.87-.13 1.02.4.49s1.38-.53 1.91 0l5.64 5.63L13.69.39c.53-.53 1.38-.53 1.91 0s.53 1.38 0 1.91L9.94 7.94l5.66 5.65c.52.53.52 1.38 0 1.91z"/></svg>
                </a>
            </div>
            <div class="a-card a-card--normal">
                <div class="chaty-popup-header font-medium text-cht-gray-150 py-4 text-left px-5">
                    Fill out at least one channel details
                </div>
                <div class="text-cht-gray-150 text-base px-5 py-6">
                    You need to fill out at least one channel details for Chaty to show up on your website
                </div>
                <input type="hidden" id="delete_widget_id" value="">
                <div class="chaty-popup-footer flex px-5">
                    <button type="button" class="btn-default close-chaty-popup-btn next-step-btn btn rounded-lg btn-primary bg-transparent text-cht-gray-150 border-cht-gray-150 hover:bg-transparent hover:text-cht-gray-150 mr-5">Save Anyway</button>
                    <button type="button" class="close-chaty-popup-btn channel-setting-step-btn btn rounded-lg">Fill channel details</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="chaty-popup" id="device-popup">
    <div class="chaty-popup-outer"></div>
    <div class="chaty-popup-inner popup-pos-bottom">
        <div class="chaty-popup-content">
            <div class="chaty-popup-close">
                <a href="javascript:void(0)" class="close-delete-pop close-chaty-popup-btn relative top-2 right-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M15.6 15.5c-.53.53-1.38.53-1.91 0L8.05 9.87 2.31 15.6c-.53.53-1.38.53-1.91 0s-.53-1.38 0-1.9l5.65-5.64L.4 2.4C-.13 1.87-.13 1.02.4.49s1.38-.53 1.91 0l5.64 5.63L13.69.39c.53-.53 1.38-.53 1.91 0s.53 1.38 0 1.91L9.94 7.94l5.66 5.65c.52.53.52 1.38 0 1.91z"/></svg>
                </a>
            </div>
            <div class="a-card a-card--normal">
                <div class="chaty-popup-header font-medium text-cht-gray-150 py-4 text-left px-5">
                    No device was selected
                </div>
                <div class="text-cht-gray-150 text-base px-5 py-6">
                    Please select mobile/desktop before publishing your widget
                </div>
                <input type="hidden" id="delete_widget_id" value="">
                <div class="chaty-popup-footer flex px-5">
                    <button type="button" class="btn-default check-for-triggers btn mr-5 rounded-lg btn-primary bg-transparent text-cht-gray-150 border-cht-gray-150 hover:bg-transparent hover:text-cht-gray-150">Save Anyway</button>
                    <button type="button" class="close-chaty-popup-btn channel-setting-btn btn rounded-lg">Select Device</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="chaty-popup" id="device-step-popup">
    <div class="chaty-popup-outer"></div>
    <div class="chaty-popup-inner popup-pos-bottom">
        <div class="chaty-popup-content">
            <div class="chaty-popup-close">
                <a href="javascript:void(0)" class="close-delete-pop close-chaty-popup-btn relative top-2 right-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M15.6 15.5c-.53.53-1.38.53-1.91 0L8.05 9.87 2.31 15.6c-.53.53-1.38.53-1.91 0s-.53-1.38 0-1.9l5.65-5.64L.4 2.4C-.13 1.87-.13 1.02.4.49s1.38-.53 1.91 0l5.64 5.63L13.69.39c.53-.53 1.38-.53 1.91 0s.53 1.38 0 1.91L9.94 7.94l5.66 5.65c.52.53.52 1.38 0 1.91z"/></svg>
                </a>
            </div>
            <div class="a-card a-card--normal">
                <div class="chaty-popup-header font-medium text-cht-gray-150 py-4 text-left px-5">
                    No device was selected
                </div>
                <div class="text-cht-gray-150 text-base px-5 py-6">
                    Please select mobile/desktop before publishing your widget
                </div>
                <input type="hidden" id="delete_widget_id" value="">
                <div class="chaty-popup-footer flex px-5">
                    <button type="button" class="btn btn-default close-chaty-popup-btn next-step-btn rounded-lg mr-5">Save Anyway</button>
                    <button type="button" class="close-chaty-popup-btn channel-setting-step-btn btn btn-primary btn btn-primary btn btn-primary btn rounded-lg btn-primary bg-transparent text-cht-gray-150 border-cht-gray-150 hover:bg-transparent hover:text-cht-gray-150">Select Device</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="chaty-popup" id="trigger-popup">
    <div class="chaty-popup-outer"></div>
    <div class="chaty-popup-inner popup-pos-bottom">
        <div class="chaty-popup-content">
            <div class="chaty-popup-close">
                <a href="javascript:void(0)" class="close-delete-pop close-chaty-popup-btn relative top-2 right-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M15.6 15.5c-.53.53-1.38.53-1.91 0L8.05 9.87 2.31 15.6c-.53.53-1.38.53-1.91 0s-.53-1.38 0-1.9l5.65-5.64L.4 2.4C-.13 1.87-.13 1.02.4.49s1.38-.53 1.91 0l5.64 5.63L13.69.39c.53-.53 1.38-.53 1.91 0s.53 1.38 0 1.91L9.94 7.94l5.66 5.65c.52.53.52 1.38 0 1.91z"/></svg>
                </a>
            </div>
            <div class="a-card a-card--normal">
                <div class="chaty-popup-header font-medium text-cht-gray-150 py-4 text-left px-5">
                    No trigger was selected
                </div>
                <div class="text-cht-gray-150 text-base px-5 py-6">
                    Please select a trigger before publishing your widget
                </div>
                <input type="hidden" id="delete_widget_id" value="">
                <div class="chaty-popup-footer flex px-5">
                    <button type="button" class="btn btn-default check-for-status rounded-lg bg-transparent text-cht-gray-150 border-cht-gray-150 hover:bg-transparent hover:text-cht-gray-150 mr-5">Save Anyway</button>
                    <button type="button" class="close-chaty-popup-btn select-trigger-btn btn-primary btn rounded-lg">Select Trigger</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="chaty-popup" id="trigger-step-popup">
    <div class="chaty-popup-outer"></div>
    <div class="chaty-popup-inner popup-pos-bottom">
        <div class="chaty-popup-content">
            <div class="chaty-popup-close">
                <a href="javascript:void(0)" class="close-delete-pop close-chaty-popup-btn relative top-2 right-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M15.6 15.5c-.53.53-1.38.53-1.91 0L8.05 9.87 2.31 15.6c-.53.53-1.38.53-1.91 0s-.53-1.38 0-1.9l5.65-5.64L.4 2.4C-.13 1.87-.13 1.02.4.49s1.38-.53 1.91 0l5.64 5.63L13.69.39c.53-.53 1.38-.53 1.91 0s.53 1.38 0 1.91L9.94 7.94l5.66 5.65c.52.53.52 1.38 0 1.91z"/></svg>
                </a>
            </div>
            <div class="a-card a-card--normal">
                <div class="chaty-popup-header font-medium text-cht-gray-150 py-4 text-left px-5">
                    No trigger was selected
                </div>
                <div class="text-cht-gray-150 text-base px-5 py-6">
                    Please select a trigger before publishing your widget
                </div>
                <input type="hidden" id="delete_widget_id" value="">
                <div class="chaty-popup-footer flex px-5">
                    <button type="button" class="btn-default close-chaty-popup-btn next-step-btn btn rounded-lg bg-transparent text-cht-gray-150 border-cht-gray-150 hover:bg-transparent hover:text-cht-gray-150 mr-5">Save Anyway</button>
                    <button type="button" class="close-chaty-popup-btn select-trigger-step-btn btn-primary btn rounded-lg">Select Trigger</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="chaty-popup" id="status-popup">
    <div class="chaty-popup-outer"></div>
    <div class="chaty-popup-inner popup-pos-bottom">
        <div class="chaty-popup-content">
            <div class="chaty-popup-close">
                <a href="javascript:void(0)" class="close-delete-pop close-chaty-popup-btn relative top-2 right-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M15.6 15.5c-.53.53-1.38.53-1.91 0L8.05 9.87 2.31 15.6c-.53.53-1.38.53-1.91 0s-.53-1.38 0-1.9l5.65-5.64L.4 2.4C-.13 1.87-.13 1.02.4.49s1.38-.53 1.91 0l5.64 5.63L13.69.39c.53-.53 1.38-.53 1.91 0s.53 1.38 0 1.91L9.94 7.94l5.66 5.65c.52.53.52 1.38 0 1.91z"/></svg>
                </a>
            </div>
            <div class="a-card a-card--normal">
                <div class="chaty-popup-header font-medium text-cht-gray-150 py-4 text-left px-5">
                    Chaty is currently off
                </div>
                <div class="text-cht-gray-150 text-base px-5 py-6">
                    Chaty is currently turned off, would you like to save and show it on your site?
                </div>
                <input type="hidden" id="delete_widget_id" value="">
                <div class="chaty-popup-footer flex px-5">
                    <button type="button" class="btn-default status-and-save btn rounded-lg bg-transparent text-cht-gray-150 border-cht-gray-150 hover:bg-transparent hover:text-cht-gray-150 mr-5">Just save and keep it off</button>
                    <button type="button" class="btn-primary change-status-btn change-status-and-save btn rounded-lg" id="keep-leads-in-db">Save &amp; Show on my site</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="chaty-popup" id="custom-leads-popup">
    <div class="chaty-popup-outer"></div>
    <div class="chaty-popup-inner popup-pos-bottom">
        <div class="chaty-popup-content">
            <div class="chaty-popup-close">
                <a href="javascript:void(0)" class="close-delete-pop close-chaty-popup-btn relative top-2 right-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M15.6 15.5c-.53.53-1.38.53-1.91 0L8.05 9.87 2.31 15.6c-.53.53-1.38.53-1.91 0s-.53-1.38 0-1.9l5.65-5.64L.4 2.4C-.13 1.87-.13 1.02.4.49s1.38-.53 1.91 0l5.64 5.63L13.69.39c.53-.53 1.38-.53 1.91 0s.53 1.38 0 1.91L9.94 7.94l5.66 5.65c.52.53.52 1.38 0 1.91z"/></svg>
                </a>
            </div>
            <div class="a-card a-card--normal">
                <div class="chaty-popup-header font-medium text-cht-gray-150 py-4 text-left px-5">
                    Are you sure?
                </div>
                <div class="text-cht-gray-150 text-base px-5 py-6">
                    You're about to turn off saving emails to your local website. Are you sure?
                </div>
                <input type="hidden" id="delete_widget_id" value="">
                <div class="chaty-popup-footer flex px-5">
                    <button type="button" class="close-chaty-popup-btn btn btn-default rounded-lg mr-5">Disable anyway</button>
                    <button type="button" class="close-chaty-popup-btn keep-leads-in-db btn rounded-lg btn-primary bg-transparent text-cht-gray-150 border-cht-gray-150 hover:bg-transparent hover:text-cht-gray-150" id="keep-leads-in-db">Keep using</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="chaty-popup" id="remove-agents-popup">
    <div class="chaty-popup-outer"></div>
    <div class="chaty-popup-inner popup-pos-bottom">
        <div class="chaty-popup-content">
            <div class="chaty-popup-close">
                <a href="javascript:void(0)" class="close-delete-pop close-chaty-popup-btn relative top-4 right-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16"><path d="M15.6 15.5c-.53.53-1.38.53-1.91 0L8.05 9.87 2.31 15.6c-.53.53-1.38.53-1.91 0s-.53-1.38 0-1.9l5.65-5.64L.4 2.4C-.13 1.87-.13 1.02.4.49s1.38-.53 1.91 0l5.64 5.63L13.69.39c.53-.53 1.38-.53 1.91 0s.53 1.38 0 1.91L9.94 7.94l5.66 5.65c.52.53.52 1.38 0 1.91z"/></svg>
                </a>
            </div>
            <div class="a-card a-card--normal">
                <div class="chaty-popup-header font-medium text-cht-gray-150 py-4 text-left px-5">
                    Remove All Agents?
                </div>
                <div class="text-cht-gray-150 text-base px-5 py-6">
                    Are you sure you want to remove all agent(s)?
                </div>
                <input type="hidden" id="delete_widget_id" value="">
                <div class="chaty-popup-footer flex px-5">
                    <button type="button" class="btn-default close-chaty-popup-btn btn rounded-lg btn-primary bg-transparent text-cht-gray-150 border-cht-gray-150 hover:bg-transparent hover:text-cht-gray-150 mr-5">No</button>
                    <button type="button" class="remove-agent-list btn rounded-lg">Yes, Remove</button>
                </div>
            </div>
        </div>
    </div>
</div>