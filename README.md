# Pixelant
## pxa_feuserbookmarks

Website User can store bookmarks to pages

# How to use
1. Install extension. Include TS.
2. Add code to fluid template

```fluid
<f:cObject typoscriptObjectPath="lib.pxaFeuserbookmarks" />
```

**If page has single view plugin like "news" extension that require additional configuration**

Add next TypoScript

```typo3_typoscript
plugin.tx_pxafeuserbookmarks {
   settings {
        specialPages {
            uidOfPage  {
                tableName = tx_news_domain_model_news
                titleField = title
                identificatorParam = tx_news_pi1|news
                urlParams = &tx_news_pi1[action]=detail&tx_news_pi1[controller]=News&tx_news_pi1[news]=###IDENTIFICATOR###
            }
        }
   }
}
```
