###Generate idm.css file

- Install `lessc` command line ([lesscss.org](http://lesscss.org/ "lesscss.org"))
- Inside `src/App/Resources/less-build` run `lessc idm.config.less ../../../../web/css/idm.css` to generate static CSS 
file
-- Add source map: lessc --source-map=../../../../web/css/idm.css.map  idm.config.less ../../../../web/css/idm.css
