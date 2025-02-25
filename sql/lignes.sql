select LIG_NUM, CD.COM_NOM as COM_NOM_DEBU, CT.COM_NOM as COM_NOM_FIN
from VIK_LIGNE 
join VIK_COMMUNE CD on COM_CODE_INSEE_DEBU = CD.COM_CODE_INSEE
join VIK_COMMUNE CT on COM_CODE_INSEE_TERM = CT.COM_CODE_INSEE
order by lig_num;