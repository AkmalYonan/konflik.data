<?php
function get_centroid($geom) {
  return $geom->centroid();
}
function wkt_to_json($wkt) {
  $geom = geoPHP::load($wkt,'wkt');
  return $geom->out('json');
}

function wkt_to_kml($wkt) {
  $geom = geoPHP::load($wkt,'wkt');
  return $geom->out('kml');
}

function wkt_to_address($wkt) {
  $geom = geoPHP::load($wkt,'wkt');
  return $geom->out('google_geocode');
}

function wkt_to_gpx($wkt) {
  $geom = geoPHP::load($wkt,'wkt');
  return $geom->out('gpx');
}

function wkt_to_georss($wkt) {
  $geom = geoPHP::load($wkt,'wkt');
  return $geom->out('georss');
}
/*
function wkt_to_address($wkt) {
  $geom = geoPHP::load($wkt,'wkt');
  return $geom->out('google_geocode');
}
*/
function json_to_centroid($json) {
  $geom = geoPHP::load($json,'json');
  $centroid = $geom->getCentroid();
  $cent['X'] = $centroid->getX();
  $cent['Y'] = $centroid->getY();
  return $geom->centroid();
}

function json_to_wkt($json) {
  $geom = geoPHP::load($json,'json');
  return $geom->out('wkt');
}

function json_to_kml($json) {
  $geom = geoPHP::load($json,'json');
  return $geom->out('kml');
}

function json_to_address($json) {
  $geom = geoPHP::load($json,'json');
  return $geom->out('google_geocode');
}

function json_to_gpx($json) {
  $geom = geoPHP::load($json,'json');
  return $geom->out('gpx');
}

function json_to_georss($wkt) {
  $geom = geoPHP::load($json,'json');
  return $geom->out('georss');
}

function kml_to_wkt($kml) {
  $geom = geoPHP::load($kml,'kml');
  return $geom->out('wkt');
}

function kml_to_json($kml) {
  $geom = geoPHP::load($kml,'kml');
  return $geom->out('json');
}

function kml_to_address($kml) {
  $geom = geoPHP::load($kml,'kml');
  return $geom->out('google_geocode');
}

function kml_to_gpx($kml) {
  $geom = geoPHP::load($kml,'kml');
  return $geom->out('gpx');
}

function kml_to_georss($kml) {
  $geom = geoPHP::load($kml,'kml');
  return $geom->out('georss');
}
/*
function kml_to_address($kml) {
  $geom = geoPHP::load($kml,'kml');
  return $geom->out('google_geocode');
}
*/
function gpx_to_wkt($gpx) {
  $geom = geoPHP::load($gpx,'gpx');
  return $geom->out('wkt');
}

function gpx_to_json($gpx) {
  $geom = geoPHP::load($gpx,'gpx');
  return $geom->out('json');
}

function gpx_to_kml($gpx) {
  $geom = geoPHP::load($gpx,'gpx');
  return $geom->out('kml');
}

function gpx_to_georss($gpx) {
  $geom = geoPHP::load($gpx,'gpx');
  return $geom->out('georss');
}

function gpx_to_address($gpx) {
  $geom = geoPHP::load($gpx,'gpx');
  return $geom->out('google_geocode');
}

function georss_to_wkt($georss) {
  $geom = geoPHP::load($georss,'georss');
  return $geom->out('wkt');
}

function georss_to_json($georss) {
  $geom = geoPHP::load($georss,'georss');
  return $geom->out('json');
}

function georss_to_kml($georss) {
  $geom = geoPHP::load($georss,'georss');
  return $geom->out('kml');
}

function georss_to_gpx($georss) {
  $geom = geoPHP::load($georss,'georss');
  return $geom->out('gpx');
}

function georss_to_address($georss) {
  $geom = geoPHP::load($georss,'georss');
  return $geom->out('google_geocode');
}

function address_to_wkt($address) {
$geom = geoPHP::load($address,'google_geocode');
  return $geom->out('wkt');
}

function address_to_json($address) {
  $geom = geoPHP::load($address,'google_geocode');
  return $geom->out('json');
}

function address_to_kml($address) {
  $geom = geoPHP::load($address,'google_geocode');
  return $geom->out('kml');
}

function address_to_gpx($address) {
  $geom = geoPHP::load($address,'google_geocode');
  return $geom->out('gpx');
}

function address_to_georss($address) {
  $geom = geoPHP::load($address,'google_geocode');
  return $geom->out('georss');
}