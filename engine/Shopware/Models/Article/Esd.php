<?php
/**
 * Shopware 4.0
 * Copyright © 2012 shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 *
 * @category   Shopware
 * @package    Shopware_Models
 * @subpackage Article
 * @copyright  Copyright (c) 2012, shopware AG (http://www.shopware.de)
 * @version    $Id$
 * @author     $Author$
 */

namespace Shopware\Models\Article;
use Shopware\Components\Model\ModelEntity,
Doctrine\ORM\Mapping AS ORM,
Symfony\Component\Validator\Constraints as Assert,
Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="s_articles_esd")
 * @ORM\HasLifecycleCallbacks
 */
class Esd extends ModelEntity
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer $articleId
     *
     * @ORM\Column(name="articleID", type="integer", nullable=false)
     */
    private $articleId;


    /**
     * @var string $file
     *
     * @ORM\Column(name="file", type="string", length=255, nullable=true)
     */
    private $file = '';

    /**
     * @var boolean $serials
     *
     * @ORM\Column(name="serials", type="boolean", nullable=false)
     */
    private $hasSerials = false;

    /**
     * @var boolean notification
     *
     * @ORM\Column(name="notification", type="boolean", nullable=false)
     */
    private $notification = false;

    /**
     * @var integer $maxdownloads
     *
     * @ORM\Column(name="maxdownloads", type="integer", nullable=false)
     */
    private $maxdownloads = 0;

    /**
     * @var \DateTime $date
     *
     * @ORM\Column(name="datum", type="datetime", nullable=true)
     */
    private $date = null;

    /**
     * INVERSE SIDE
     *
     * @ORM\OneToOne(targetEntity="Shopware\Models\Attribute\ArticleEsd", mappedBy="articleEsd", cascade={"persist"})
     * @var \Shopware\Models\Attribute\ArticleEsd
     */
    protected $attribute;

    /**
     * INVERSE SIDE
     *
     * @ORM\OneToMany(targetEntity="Shopware\Models\Article\EsdSerial", mappedBy="esd")
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    protected $serials;

    /**
     * OWNING SIDE
     *
     * @ORM\ManyToOne(targetEntity="Shopware\Models\Article\Article", inversedBy="esds")
     * @ORM\JoinColumn(name="articleID", referencedColumnName="id")
     * @var \Shopware\Models\Article\Article
     */
    protected $article;

    /**
     * OWNING SIDE
     *
     * @ORM\OneToOne(targetEntity="Shopware\Models\Article\Detail", inversedBy="esd")
     * @ORM\JoinColumn(name="articleDetailsID", referencedColumnName="id")
     * @var \Shopware\Models\Article\Detail
     */
    protected $articleDetail;

    /**
     * Class constructor.
     */
    public function __construct()
    {
        $this->serials = new ArrayCollection();
    }

    /**
     * @return \Shopware\Models\Attribute\ArticleEsd
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * @param \Shopware\Models\Attribute\ArticleEsd|array|null $attribute
     * @return \Shopware\Models\Attribute\ArticleEsd
     */
    public function setAttribute($attribute)
    {
        return $this->setOneToOne($attribute, '\Shopware\Models\Attribute\ArticleEsd', 'attribute', 'articleEsd');
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $serials
     */
    public function setSerials($serials)
    {
        $this->serials = $serials;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getSerials()
    {
        return $this->serials;
    }

    /**
     * @param \Shopware\Models\Article\Article $article
     */
    public function setArticle($article)
    {
        throw new \Exception('Article should be set implicit with setArticleDetail');

    }

    /**
     * @return \Shopware\Models\Article\Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param \Shopware\Models\Article\Detail $articleDetail
     */
    public function setArticleDetail(\Shopware\Models\Article\Detail $articleDetail)
    {
        $this->articleDetail = $articleDetail;
        $this->article       = $articleDetail->getArticle();
    }

    /**
     * @return \Shopware\Models\Article\Detail
     */
    public function getArticleDetail()
    {
        return $this->articleDetail;
    }

    /**
     * @param null|\DateTime $date
     * @return Esd
     */
    public function setDate($date = null)
    {
        if ($date !== null && !($date instanceof \DateTime)) {
            $this->date = new \DateTime($date);
        } else {
            $this->date = $date;
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param boolean $hasSerials
     */
    public function setHasSerials($hasSerials)
    {
        $this->hasSerials = $hasSerials;
    }

    /**
     * @return boolean
     */
    public function getHasSerials()
    {
        return $this->hasSerials;
    }

    /**
     * @param int $maxdownloads
     */
    public function setMaxdownloads($maxdownloads)
    {
        $this->maxdownloads = $maxdownloads;
    }

    /**
     * @return int
     */
    public function getMaxdownloads()
    {
        return $this->maxdownloads;
    }

    /**
     * @param boolean $notification
     */
    public function setNotification($notification)
    {
        $this->notification = $notification;
    }

    /**
     * @return boolean
     */
    public function getNotification()
    {
        return $this->notification;
    }

    /**
     * Sets date on pre persist
     *
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->date = new \DateTime('now');
    }
}
