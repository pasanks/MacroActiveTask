<?php
return [

    /**
     * You can generate API keys here: https://cloudconvert.com/dashboard/api/v2/keys.
     */

    'api_key' => env('CLOUDCONVERT_API_KEY', 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNjgyM2FlMWM4M2MwMTRmNjNkOWMwZDBjN2MxNjg4NDY0NjNjMjM2YjZlZjg2YWVkOTkyMzk2NDhjMGZiMzA3MDY2MDJlZDc1MjE2Mzk0YzUiLCJpYXQiOjE2MjM3ODUyOTEuNTA0NzcsIm5iZiI6MTYyMzc4NTI5MS41MDQ3NzMsImV4cCI6NDc3OTQ1ODg5MS40NjE4MDQsInN1YiI6IjUxNzgyNzE1Iiwic2NvcGVzIjpbInVzZXIucmVhZCIsInVzZXIud3JpdGUiLCJ0YXNrLnJlYWQiLCJ0YXNrLndyaXRlIiwid2ViaG9vay5yZWFkIiwid2ViaG9vay53cml0ZSIsInByZXNldC5yZWFkIiwicHJlc2V0LndyaXRlIl19.pqvXgOj0FYxqipsIWq6hWpFIaZogGePwnbuv-UE5V_Mv19s4meN4xbZtiZE-xV6af4VfHfTzJp318KybrEFGsk6NqAkhVWIaGGgEVyDphvfWcwRKtqEZ4KSg1SgbiFL7J5DNORXRylwioZtdL39oJnbRgPs401ul2-t8JVFqUiS0c8HpJwweAVS22VfPZF2dz_DFJW6fotcb-ogndZuv2FeWYe5fmMgFqHa5i_II9CUcLDQOlmJxceSGlSqD6Llc_Tyj1mTV6zL1uRAxhc4rDKN_Y77hHx3vc1FRIJUeww5R-1HIjlrxl0Pj3qgG1-qJhfPjZ5M30ogZb41GrFvq7i_Aj4Db6H_IaNyDFcdA2cRsEX6Z2Mm-HKVLzIVYiBnOL4Hh44PU5bpTjbIv1zoVge-95W6wrgLcew3W8kTuhfL31Ub2bKsgeHh4g-9F6bfxOXOU_Vo7XzC-4RKMAOR6sSQXFVO7yvuo8kfHuGXHlP-OWqVV_iLnGjKLIsRBm-ncErcdkrCWSzUAynHAOX6gtqn1f9ZSY93SAfx-SqbkL6nAHl_UJhadNQyfgTZWXIuTglI3OopcpihrNWN0NlrDA6kZRQ94vNkjkZAMyWr1WAtZyU1hJg5Gt6Kz4NWDS1z5qZ5cPTsFD35O8EjQlSfcSwZI9mpSrOabz3v9B2qxn8s'),

    /**
     * Use the CloudConvert Sanbox API (Defaults to false, which enables the Production API).
     */
    'sandbox' => env('CLOUDCONVERT_SANDBOX', true),

    /**
     * You can find the secret used at the webhook settings: https://cloudconvert.com/dashboard/api/v2/webhooks
     */
    'webhook_signing_secret' => env('CLOUDCONVERT_WEBHOOK_SIGNING_SECRET', '')

];
