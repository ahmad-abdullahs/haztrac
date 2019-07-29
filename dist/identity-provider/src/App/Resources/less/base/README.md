###Generate idm.css file

- Install `lessc` command line ([lesscss.org](http://lesscss.org/ "lesscss.org"))
- Inside `src/less` run `lessc idm.config.less ../../css/less` to generate static CSS file (change target path as necessary)
-- Add source map: lessc --source-map=../../css/idm.css.map  idm.config.less ../../css/idm.css
