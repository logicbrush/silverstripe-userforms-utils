<% if $Showing %>

<% if $ShowFormTitle %>
<h2>$FormPage.Title</h2>
<% end_if %>

<% if $ShowFormContent %>
$FormContent
<% end_if %>

<% if IntroText %>
<p>$IntroText</p>
<% end_if %>

$UserDefinedForm

<% end_if %>
